<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_browser_reset_changes_password_and_enables_local_password(): void
    {
        $user = User::factory()->create(['has_local_password' => false, 'google_id' => 'google-subject']);
        $token = Password::broker('users')->createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect(route('login'))->assertHeader('Referrer-Policy', 'no-referrer');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        $user->refresh();
        $this->assertTrue(Hash::check('new-password-123', $user->password));
        $this->assertTrue($user->has_local_password);
        $this->assertSame('google-subject', $user->google_id);
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);

        $invalid = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'another-password-123',
            'password_confirmation' => 'another-password-123',
        ])->assertSessionHasErrors('email')->assertHeader('Referrer-Policy', 'no-referrer');
        $this->assertStringContainsString('no-store', $invalid->headers->get('Cache-Control'));
    }

    public function test_reset_page_html_omits_analytics_and_is_not_cacheable_or_referrable(): void
    {
        $user = User::factory()->create();
        $response = $this->get(route('password.reset', ['token' => 'opaque-test-token', 'email' => $user->email]))
            ->assertOk()
            ->assertHeader('Referrer-Policy', 'no-referrer');

        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $response->assertDontSee('googletagmanager.com/gtag/js', false);
    }

    public function test_reset_revokes_old_api_credentials_and_deletes_only_the_users_database_sessions(): void
    {
        config(['session.driver' => 'database', 'session.connection' => null, 'session.table' => 'sessions']);
        $user = User::factory()->create();
        $other = User::factory()->create();
        $oldAccess = 'access-credential-for-reset-user';
        $oldRefresh = 'refresh-credential-for-reset-user';
        $otherAccess = 'access-credential-for-other-user';
        $otherRefresh = 'refresh-credential-for-other-user';
        $this->insertCredentialPair($user, $oldAccess, $oldRefresh);
        $this->insertCredentialPair($other, $otherAccess, $otherRefresh);
        DB::table('sessions')->insert([
            ['id' => 'reset-session', 'user_id' => $user->id, 'payload' => '', 'last_activity' => time()],
            ['id' => 'other-session', 'user_id' => $other->id, 'payload' => '', 'last_activity' => time()],
        ]);
        $token = Password::broker('users')->createToken($user);

        $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect(route('login'));

        $this->withToken($oldAccess)->getJson('/api/me')->assertUnauthorized();
        $this->postJson('/api/refresh-token', ['refresh_token' => $oldRefresh])->assertUnauthorized();
        $this->withToken($otherAccess)->getJson('/api/me')->assertOk();
        $this->postJson('/api/refresh-token', ['refresh_token' => $otherRefresh])->assertOk();
        $this->assertDatabaseMissing('sessions', ['id' => 'reset-session']);
        $this->assertDatabaseHas('sessions', ['id' => 'other-session', 'user_id' => $other->id]);
    }

    public function test_missing_or_invalid_email_on_reset_link_redirects_to_login_with_privacy_headers(): void
    {
        $missing = $this->get('/reset-password/fake-token')->assertRedirect(route('login'))
            ->assertSessionHas('show_forgot_modal', true)->assertHeader('Referrer-Policy', 'no-referrer');
        $this->assertStringContainsString('no-store', $missing->headers->get('Cache-Control'));

        $invalid = $this->get('/reset-password/fake-token?email=bad')->assertRedirect(route('login'))
            ->assertHeader('Referrer-Policy', 'no-referrer');
        $this->assertStringContainsString('no-store', $invalid->headers->get('Cache-Control'));
    }

    private function insertCredentialPair(User $user, string $access, string $refresh): void
    {
        DB::table('api_tokens')->insert([
            'user_id' => $user->id,
            'access_token_hash' => hash('sha256', $access),
            'refresh_token_hash' => hash('sha256', $refresh),
            'access_expires_at' => now()->addHour(),
            'refresh_expires_at' => now()->addDay(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
