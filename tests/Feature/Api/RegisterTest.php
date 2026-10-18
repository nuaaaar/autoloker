<?php

namespace Tests\Feature\Api;

use App\Http\Requests\Api\RegisterRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\CleaningService;
use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserCleaningService;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->bind(RegisterRequest::class, fn () => new class extends RegisterRequest
        {
            public function rules(): array
            {
                $rules = parent::rules();
                $rules['email'][array_search('email:rfc,dns', $rules['email'], true)] = 'email:rfc';

                return $rules;
            }
        });
    }

    #[DataProvider('registrationCases')]
    public function test_registration_creates_the_selected_role_profile(array $payload, string $dbRole): void
    {
        $response = $this->postJson('/api/register', $payload);

        $response->assertCreated()->assertJsonPath('data.role', $dbRole);
        $user = User::where('email', $payload['email'])->firstOrFail();
        $this->assertSame($user->id, $response->json('data.id'));
        $this->assertTrue(Hash::check('Secret123', $user->password));

        if ($dbRole === 'cs') {
            $link = UserCleaningService::where('user_id', $user->id)->firstOrFail();
            $profile = CleaningService::where('user_cleaning_service_id', $link->id)->firstOrFail();
            $this->assertSame($payload['name'], $profile->name);
            $this->assertSame($payload['email'], $profile->email);
            $this->assertSame($payload['phone_number'] ?? null, $profile->phone_number);
            $this->assertDatabaseMissing('user_securities', ['user_id' => $user->id]);
        } elseif ($dbRole === 'satpam') {
            $link = UserSecurity::where('user_id', $user->id)->firstOrFail();
            $profile = Security::where('user_security_id', $link->id)->firstOrFail();
            $this->assertSame($payload['name'], $profile->name);
            $this->assertSame($payload['email'], $profile->email);
            $this->assertSame($payload['phone_number'], $profile->phone_number);
        } else {
            $link = UserCompany::where('user_id', $user->id)->firstOrFail();
            $profile = Company::where('user_company_id', $link->id)->firstOrFail();
            $this->assertSame($payload['name'], $profile->company_name);
            $this->assertSame($payload['email'], $profile->email);
        }
    }

    public static function registrationCases(): array
    {
        return [
            'cs without phone' => [self::payload('cs-no-phone@example.com', 'cs'), 'cs'],
            'cs with phone' => [self::payload('cs-with-phone@example.com', 'cs', '081234567890'), 'cs'],
            'security' => [self::payload('security@example.com', 'security', '081234567891'), 'satpam'],
            'company' => [self::payload('company@example.com', 'company'), 'company'],
        ];
    }

    private static function payload(string $email, string $role, ?string $phone = null): array
    {
        return array_filter([
            'role' => $role,
            'name' => 'Siti Rahma',
            'email' => $email,
            'password' => 'Secret123',
            'password_confirmation' => 'Secret123',
            'agree' => true,
            'phone_number' => $phone,
        ], fn ($value) => $value !== null);
    }

    public function test_cs_registration_can_login_and_load_cs_profile_without_role_switch(): void
    {
        $payload = self::payload('cs-login@example.test', 'cs');
        $this->postJson('/api/register', $payload)->assertCreated();

        $login = $this->postJson('/api/login', [
            'role' => 'cs', 'identifier' => $payload['email'], 'password' => 'Secret123',
        ])->assertOk()->assertJsonPath('data.user.role', 'cs');

        $profile = $this->withToken($login->json('data.access_token'))->getJson('/api/profile')->assertOk();
        $profile->assertJsonPath('data.profile.type', 'cs')
            ->assertJsonPath('data.profile.data.name', $payload['name'])
            ->assertJsonPath('data.profile.data.email', $payload['email']);
    }

    public function test_missing_or_unsupported_role_is_rejected_without_user(): void
    {
        foreach ([[], ['role' => 'admin']] as $role) {
            $payload = self::payload('invalid'.count(User::all()).'@example.test', 'security', '081234567890');
            unset($payload['role']);
            $payload = array_merge($payload, $role);
            $this->postJson('/api/register', $payload)->assertUnprocessable()->assertJsonValidationErrors('role');
            $this->assertSame(0, User::count());
            $this->assertSame(0, UserSecurity::count());
            $this->assertSame(0, UserCleaningService::count());
            $this->assertSame(0, UserCompany::count());
        }
    }
}
