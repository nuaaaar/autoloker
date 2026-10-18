<?php

namespace Tests\Feature\Api;

use App\Models\ApiToken;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserCleaningService;
use App\Models\UserSecurity;
use App\Services\Api\RegistrationService;
use App\Services\Api\TokenService;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
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

    public function test_local_account_with_matching_verified_google_email_is_linked_and_remains_usable(): void
    {
        foreach ([
            ['security', 'blank', 'link-security@example.test', 'google-link-security'],
            ['cs', 'null', 'link-cs@example.test', 'google-link-cs'],
            ['company', 'blank', 'link-company@example.test', 'google-link-company'],
        ] as [$role, $subjectState, $email, $subject]) {
            $user = app(RegistrationService::class)->register([
                'role' => $role,
                'name' => 'Existing Local User',
                'email' => $email,
                'password' => 'LocalPass123',
                'phone_number' => $role === 'security' ? '081234567891' : null,
            ]);
            if ($subjectState === 'null') {
                $user->forceFill(['google_id' => null])->save();
            }
            $user->refresh();
            $hash = $user->password;
            $profileId = match ($role) {
                'security' => UserSecurity::where('user_id', $user->id)->value('id'),
                'cs' => UserCleaningService::where('user_id', $user->id)->value('id'),
                'company' => UserCompany::where('user_id', $user->id)->value('id'),
            };
            $initialUsers = User::count();
            $token = $this->token(['sub' => $subject, 'email' => $email]);

            $this->postJson('/api/auth/google/register', ['role' => $role, 'id_token' => $token])
                ->assertUnprocessable()->assertJsonValidationErrors('email');
            $this->assertSame($subjectState === 'null' ? null : '', $user->fresh()->google_id);

            $response = $this->postJson('/api/auth/google/login', ['role' => $role, 'id_token' => $token])
                ->assertOk()->assertJsonPath('data.user.uuid', $user->uuid);
            $user->refresh();
            $this->assertSame($subject, $user->google_id);
            $this->assertSame($hash, $user->password);
            $this->assertTrue($user->has_local_password);
            $this->assertSame($profileId, match ($role) {
                'security' => UserSecurity::where('user_id', $user->id)->value('id'),
                'cs' => UserCleaningService::where('user_id', $user->id)->value('id'),
                'company' => UserCompany::where('user_id', $user->id)->value('id'),
            });
            $this->assertSame($initialUsers, User::count());
            $this->assertDatabaseHas('api_tokens', [
                'user_id' => $user->id,
                'access_token_hash' => hash('sha256', $response->json('data.access_token')),
            ]);
            $this->withToken($response->json('data.access_token'))->getJson('/api/me')
                ->assertOk()->assertJsonPath('data.user.uuid', $user->uuid);
            $this->postJson('/api/auth/google/login', ['role' => $role, 'id_token' => $token])
                ->assertOk()->assertJsonPath('data.user.uuid', $user->uuid);
            $this->postJson('/api/login', [
                'role' => $role, 'identifier' => $email, 'password' => 'LocalPass123',
            ])->assertOk()->assertJsonPath('data.user.uuid', $user->uuid);
            $this->assertSame($initialUsers, User::count());
        }
    }

    public function test_google_login_rejects_unknown_subject_conflicting_email_and_duplicate_subject(): void
    {
        $local = app(RegistrationService::class)->register([
            'role' => 'security', 'name' => 'Local User', 'email' => 'local@example.test',
            'password' => 'LocalPass123', 'phone_number' => '081234567891',
        ]);
        $linked = app(RegistrationService::class)->register([
            'role' => 'company', 'name' => 'Linked User', 'email' => 'linked@example.test',
            'password' => 'LocalPass123',
        ]);
        $linked->forceFill(['google_id' => 'owner-sub'])->save();
        $beforeTokens = ApiToken::count();

        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token([
            'sub' => 'unknown-sub', 'email' => 'unknown@example.test',
        ])])->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertSame(2, User::count());
        $this->assertSame($beforeTokens, ApiToken::count());

        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token([
            'sub' => 'replacement-sub', 'email' => 'linked@example.test',
        ])])->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertSame('owner-sub', $linked->fresh()->google_id);

        User::whereKey($local->id)->update(['google_id' => 'duplicate-sub']);
        User::whereKey($linked->id)->update(['google_id' => 'duplicate-sub']);
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token([
            'sub' => 'duplicate-sub', 'email' => 'local@example.test',
        ])])->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertSame($beforeTokens, ApiToken::count());
    }

    public function test_google_login_rejects_unverified_email_inactive_accounts_and_incompatible_roles(): void
    {
        $local = app(RegistrationService::class)->register([
            'role' => 'security', 'name' => 'Local User', 'email' => 'unverified@example.test',
            'password' => 'LocalPass123', 'phone_number' => '081234567891',
        ]);
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token([
            'sub' => 'unverified-sub', 'email' => 'unverified@example.test', 'email_verified' => false,
        ])])->assertUnprocessable()->assertJsonValidationErrors('id_token');
        $this->assertSame('', $local->fresh()->google_id);
        $this->assertSame(0, ApiToken::count());

        $local->update(['status' => 'inactive']);
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token([
            'sub' => 'inactive-sub', 'email' => 'unverified@example.test',
        ])])->assertUnprocessable();
        $this->assertSame('', $local->fresh()->google_id);
        $this->assertSame(0, ApiToken::count());

        $company = app(RegistrationService::class)->register([
            'role' => 'company', 'name' => 'Local Company', 'email' => 'company@example.test',
            'password' => 'LocalPass123',
        ]);
        $this->postJson('/api/auth/google/login', ['role' => 'security', 'id_token' => $this->token([
            'sub' => 'company-sub', 'email' => 'company@example.test',
        ])])->assertUnprocessable()->assertJsonValidationErrors('role');
        $this->assertSame('', $company->fresh()->google_id);
        $this->assertSame(0, ApiToken::count());
    }

    public function test_google_login_rolls_back_link_and_role_profile_when_token_issue_fails(): void
    {
        $user = app(RegistrationService::class)->register([
            'role' => 'security', 'name' => 'Local User', 'email' => 'rollback@example.test',
            'password' => 'LocalPass123', 'phone_number' => '081234567891',
        ]);
        $securityProfileId = UserSecurity::where('user_id', $user->id)->value('id');
        $this->mock(TokenService::class)->shouldReceive('issue')->once()->andThrow(new \RuntimeException('token issue failure'));

        $this->postJson('/api/auth/google/login', ['role' => 'cs', 'id_token' => $this->token([
            'sub' => 'rollback-sub', 'email' => 'rollback@example.test',
        ])])->assertInternalServerError();
        $user->refresh();
        $this->assertSame('satpam', $user->role);
        $this->assertSame('', $user->google_id);
        $this->assertSame($securityProfileId, UserSecurity::where('user_id', $user->id)->value('id'));
        $this->assertSame(0, UserCleaningService::where('user_id', $user->id)->count());
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
