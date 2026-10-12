<?php

namespace Tests\Feature\Api;

use App\Models\ApiToken;
use App\Models\User;
use App\Services\Api\TokenService;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    private string $privateKey = '';
    private string $modulus;
    private string $exponent;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.google.server_client_id' => 'flutter-test.apps.googleusercontent.com']);
        config(['services.google.client_id' => 'web-test.apps.googleusercontent.com']);
        $key = openssl_pkey_new(['private_key_type' => OPENSSL_KEYTYPE_RSA, 'private_key_bits' => 2048]);
        openssl_pkey_export($key, $this->privateKey);
        $details = openssl_pkey_get_details($key);
        $this->modulus = $this->base64url($details['rsa']['n']);
        $this->exponent = $this->base64url($details['rsa']['e']);

        Http::preventStrayRequests();
        Http::fake([
            'https://www.googleapis.com/oauth2/v3/certs' => Http::response(['keys' => [[
                'kty' => 'RSA', 'alg' => 'RS256', 'use' => 'sig', 'kid' => 'test-key',
                'n' => $this->modulus, 'e' => $this->exponent,
            ]]]),
        ]);
    }

    public function test_mobile_google_issuer_is_accepted_for_registration_and_login(): void
    {
        $token = $this->token(['iss' => 'accounts.google.com']);
        $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $token])
            ->assertCreated();
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $token])
            ->assertOk()->assertJsonPath('data.user.email', 'google-test@example.com');
    }

    public function test_mobile_issuer_does_not_bypass_signature_verification(): void
    {
        $parts = explode('.', $this->token());
        $claims = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true, flags: JSON_THROW_ON_ERROR);
        $claims['iss'] = 'accounts.google.com';
        $parts[1] = $this->base64url(json_encode($claims, JSON_THROW_ON_ERROR));

        $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => implode('.', $parts)])
            ->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('api_tokens', 0);
    }

    public function test_google_auth_uses_mobile_audience_instead_of_website_audience(): void
    {
        $websiteToken = $this->token(['aud' => 'web-test.apps.googleusercontent.com']);
        $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $websiteToken])
            ->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertSame(0, User::count());
        $this->assertSame(0, ApiToken::count());

        $mobileToken = $this->token();
        $response = $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $mobileToken])
            ->assertCreated();
        $user = User::where('google_id', 'google-test-sub')->firstOrFail();
        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $user->id,
            'access_token_hash' => hash('sha256', $response->json('data.access_token')),
        ]);
        $this->assertNotSame('', $response->json('data.access_token'));
        $this->assertNotSame('', $response->json('data.refresh_token'));
    }

    public function test_missing_mobile_audience_fails_closed_even_when_website_audience_is_configured(): void
    {
        config(['services.google.server_client_id' => null]);

        $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $this->token()])
            ->assertServiceUnavailable();
        $this->assertSame(0, User::count());
        $this->assertSame(0, ApiToken::count());
    }

    public function test_register_google_creates_role_profile_and_api_token(): void
    {
        foreach ([['security', 'satpam', 'security'], ['cs', 'cs', 'cs'], ['company', 'company', 'company']] as [$role, $storedRole, $profileType]) {
            $token = $this->token(['sub' => 'google-'.$role, 'email' => $role.'@google-test.example']);
            $response = $this->postJson('/api/auth/google/register', ['role' => $role, 'id_token' => $token])
                ->assertCreated()->assertJsonPath('data.user.role', $storedRole)
                ->assertJsonPath('data.user.profile.type', $profileType);
            $user = User::where('google_id', 'google-'.$role)->firstOrFail();
            $this->assertTrue($user->has_local_password === false);
            $this->assertNotNull($user->email_verified_at);
            $this->assertNull($user->phone_number);
            $this->assertSame(0, ApiToken::where('user_id', $user->id)->where('access_token_hash', $response->json('data.access_token'))->count());
            $this->assertDatabaseHas('api_tokens', ['user_id' => $user->id, 'access_token_hash' => hash('sha256', $response->json('data.access_token'))]);
            $this->withToken($response->json('data.access_token'))->getJson('/api/me')->assertOk()->assertJsonPath('data.user.uuid', $user->uuid);
        }
    }

    public function test_login_requires_registered_google_subject_and_switches_worker_role(): void
    {
        $registration = $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $this->token()])->assertCreated();
        $user = User::where('google_id', 'google-test-sub')->firstOrFail();
        $this->postJson('/api/auth/google/login', ['role' => 'cs', 'id_token' => $this->token()])->assertOk()->assertJsonPath('data.user.role', 'cs');
        $this->assertSame('cs', $user->fresh()->role);
        $this->assertNotNull($user->user_security);
        $this->assertNotNull($user->user_cleaning_service);
        $this->postJson('/api/auth/google/login', ['role' => 'company', 'id_token' => $this->token()])->assertUnprocessable();
        $this->assertSame(2, ApiToken::where('user_id', $user->id)->count());
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token(['sub' => 'unknown-sub'])])->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertNotSame('', $registration->json('data.access_token'));
    }

    public function test_invalid_google_claims_and_bad_tokens_are_rejected_without_users(): void
    {
        $badTokens = [
            'broken',
            $this->token(['aud' => 'wrong-client']),
            $this->token(['iss' => 'https://wrong.example']),
            $this->token(['exp' => time() - 1]),
            $this->token(['exp' => null]),
            $this->token(['email_verified' => false]),
            $this->token(['sub' => null]),
            $this->token(['email' => null]),
        ];
        foreach ($badTokens as $badToken) {
            $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $badToken])->assertUnprocessable();
        }
        $this->assertSame(0, User::count());
        $this->postJson('/api/auth/google/register', ['role' => 'admin', 'id_token' => $this->token()])->assertUnprocessable();
        $this->postJson('/api/auth/google/register', ['role' => 'security'])->assertUnprocessable();
    }

    public function test_existing_email_is_not_linked_or_changed(): void
    {
        $user = User::create(['name' => 'Local User', 'email' => 'google-test@example.com', 'password' => 'local-password', 'role' => 'satpam', 'status' => 'active', 'google_id' => null]);
        $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $this->token()])->assertUnprocessable();
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token()])->assertUnprocessable();
        $this->assertNull($user->fresh()->google_id);
        $this->assertSame(0, ApiToken::count());
    }

    public function test_google_registration_rolls_back_profile_when_token_issue_fails(): void
    {
        $this->mock(TokenService::class)->shouldReceive('issue')->once()->andThrow(new \RuntimeException('token issue failure'));
        $this->postJson('/api/auth/google/register', ['role' => 'security', 'id_token' => $this->token()])->assertInternalServerError();
        $this->assertSame(0, User::count());
        $this->assertDatabaseCount('user_securities', 0);
        $this->assertDatabaseCount('securities', 0);
    }

    private function token(array $overrides = []): string
    {
        $claims = array_replace([
            'iss' => 'https://accounts.google.com',
            'aud' => 'flutter-test.apps.googleusercontent.com',
            'sub' => 'google-test-sub',
            'email' => 'google-test@example.com',
            'email_verified' => true,
            'name' => 'Google Test',
            'iat' => time() - 60,
            'exp' => time() + 3600,
        ], $overrides);
        if (($claims['exp'] ?? 'missing') === null) {
            unset($claims['exp']);
        }
        if (($claims['sub'] ?? 'missing') === null) {
            unset($claims['sub']);
        }
        if (($claims['email'] ?? 'missing') === null) {
            unset($claims['email']);
        }

        return JWT::encode($claims, $this->privateKey, 'RS256', 'test-key');
    }

    private function base64url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
