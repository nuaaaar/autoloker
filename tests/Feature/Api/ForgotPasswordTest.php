<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['queue.default' => 'database', 'mail.default' => 'array']);
        Notification::fake();
    }

    public function test_known_and_unknown_requests_share_a_neutral_response_and_only_known_accounts_receive_mail(): void
    {
        $user = User::factory()->create();

        $expected = [
            'status' => true,
            'message' => 'Jika alamat email terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.',
        ];
        $this->postJson('/api/forgot-password', ['email' => $user->email])->assertStatus(202)->assertExactJson($expected);
        $this->postJson('/api/forgot-password', ['email' => 'missing@example.com'])->assertStatus(202)->assertExactJson($expected);

        $this->assertDatabaseCount('password_reset_tokens', 0);
        $this->assertDatabaseCount('jobs', 2);
        $this->assertSame(0, Notification::sent($user, ResetPassword::class)->count());

        $this->artisan('queue:work', ['connection' => 'database', '--queue' => 'default', '--once' => true])->assertExitCode(0);
        Notification::assertSentTo($user, ResetPassword::class);
        $this->artisan('queue:work', ['connection' => 'database', '--queue' => 'default', '--once' => true])->assertExitCode(0);
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user): bool {
            $this->assertNotEmpty($notification->token);
            $this->assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);

            return true;
        });
        $this->assertDatabaseCount('jobs', 0);
        Notification::assertSentToTimes($user, ResetPassword::class, 1);
    }

    public function test_request_limit_returns_retry_after_and_reset_links_ignore_request_host(): void
    {
        config(['app.url' => 'https://trusted.example']);
        $user = User::factory()->create();

        for ($attempt = 0; $attempt < 4; $attempt++) {
            $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1'])->withHeader('Host', 'attacker.example')
                ->postJson('/api/forgot-password', ['email' => $user->email])->assertStatus(202);
        }
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1'])
            ->post('/forgot-password', ['email' => $user->email])->assertRedirect();

        $limited = $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1'])->withHeader('Host', 'attacker.example')
            ->postJson('/api/forgot-password', ['email' => $user->email]);
        $limited->assertStatus(429)->assertHeader('Retry-After');

        $independentIp = $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.2'])
            ->postJson('/api/forgot-password', ['email' => $user->email]);
        $independentIp->assertStatus(202);
        $this->assertGreaterThan(0, (int) $limited->headers->get('Retry-After'));
        $this->artisan('queue:work', ['connection' => 'database', '--queue' => 'default', '--once' => true])->assertExitCode(0);
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user): bool {
            $url = $notification->toMail($user)->actionUrl;
            $this->assertStringStartsWith('https://trusted.example/reset-password/', $url);
            $this->assertStringNotContainsString('attacker.example', $url);

            return true;
        });
    }

    public function test_invalid_email_returns_validation_errors(): void
    {
        $this->postJson('/api/forgot-password', ['email' => 'not-an-email'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        $this->assertDatabaseCount('jobs', 0);
    }
}
