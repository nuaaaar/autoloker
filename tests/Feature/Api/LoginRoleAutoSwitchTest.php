<?php

namespace Tests\Feature\Api;

use App\Models\CleaningService;
use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserCleaningService;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Worker accounts may log in with either worker role; the server switches the
 * account role to the requested one. Company accounts must keep an exact match.
 */
class LoginRoleAutoSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_worker_login_with_other_worker_role_switches_role(): void
    {
        $email = 'switch-a@example.com';
        [$user] = $this->securityAccount($email);
        $this->assertNull($user->user_cleaning_service);

        $response = $this->postJson('/api/login', [
            'role' => 'cs',
            'identifier' => $email,
            'password' => 'password',
        ])->assertOk()
            ->assertJsonPath('data.user.role', 'cs')
            ->assertJsonPath('data.user.profile.type', 'cs');

        $this->assertSame('cs', User::find($user->id)->role);
        $this->assertNotNull(UserCleaningService::where('user_id', $user->id)->first());
        $this->assertNotNull(UserSecurity::where('user_id', $user->id)->first());

        $token = $response->json('data.access_token');
        $this->withToken($token)->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('data.user.role', 'cs');
    }

    public function test_cs_login_with_security_role_switches_to_satpam(): void
    {
        $email = 'switch-b@example.com';
        [$user] = $this->csAccount($email);

        $this->postJson('/api/login', [
            'role' => 'security',
            'identifier' => $email,
            'password' => 'password',
        ])->assertOk()
            ->assertJsonPath('data.user.role', 'satpam')
            ->assertJsonPath('data.user.profile.type', 'security');

        $this->assertSame('satpam', User::find($user->id)->role);
        $this->assertNotNull(UserSecurity::where('user_id', $user->id)->first());
    }

    public function test_login_with_matching_role_keeps_role_without_switch(): void
    {
        $email = 'switch-c@example.com';
        [$user] = $this->securityAccount($email);

        $this->postJson('/api/login', [
            'role' => 'security',
            'identifier' => $email,
            'password' => 'password',
        ])->assertOk()
            ->assertJsonPath('data.user.role', 'satpam')
            ->assertJsonPath('data.user.profile.type', 'security');

        $this->assertSame('satpam', User::find($user->id)->role);
        $this->assertSame(0, UserCleaningService::where('user_id', $user->id)->count());
    }

    public function test_company_login_with_worker_role_is_still_rejected(): void
    {
        $email = 'switch-company@example.com';
        [$user] = $this->companyAccount($email);

        foreach (['security', 'cs'] as $role) {
            $this->postJson('/api/login', [
                'role' => $role,
                'identifier' => $email,
                'password' => 'password',
            ])->assertStatus(422)
                ->assertJsonValidationErrors(['role'])
                ->assertJsonPath('errors.role.0', 'Peran akun tidak sesuai.');
        }

        $this->assertSame('company', User::find($user->id)->role);

        $this->postJson('/api/login', [
            'role' => 'company',
            'identifier' => $email,
            'password' => 'password',
        ])->assertOk()
            ->assertJsonPath('data.user.role', 'company');
    }

    /** @return array{0: User, 1: Security} */
    private function securityAccount(string $email): array
    {
        $user = User::create([
            'name' => 'Auto Switch Security',
            'email' => $email,
            'phone_number' => '081200000001',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        $security = Security::create([
            'user_security_id' => $relation->id,
            'formal_photo' => 'formal-photo/auto-switch.jpg',
            'name' => 'Auto Switch Security',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-01-01',
            'gender' => 'laki-laki',
            'address' => 'Jl. Merdeka 1',
            'phone_number' => '081200000001',
            'email' => $email,
            'ktp_number' => '3273010101950001',
            'registration_number' => 'REG-AUTO-001',
            'work_experience' => '3 tahun',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'village' => 'Dago',
            'height' => '170',
            'width' => '65',
            'is_out_of_town_agree' => true,
            'is_shift_agree' => true,
            'ability' => 'Patroli',
            'work_status' => 'Siap kerja',
        ]);

        return [$user, $security];
    }

    /** @return array{0: User, 1: CleaningService} */
    private function csAccount(string $email): array
    {
        $user = User::create([
            'name' => 'Auto Switch CS',
            'email' => $email,
            'phone_number' => '081200000002',
            'google_id' => null,
            'password' => 'password',
            'role' => 'cs',
            'status' => 'active',
        ]);
        $relation = UserCleaningService::create(['user_id' => $user->id]);
        $cleaningService = CleaningService::create([
            'user_cleaning_service_id' => $relation->id,
            'name' => 'Auto Switch CS',
        ]);

        return [$user, $cleaningService];
    }

    /** @return array{0: User, 1: Company} */
    private function companyAccount(string $email): array
    {
        $user = User::create([
            'name' => 'Auto Switch Company',
            'email' => $email,
            'phone_number' => '081200000003',
            'google_id' => null,
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $relation = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create([
            'user_company_id' => $relation->id,
            'company_name' => 'Auto Switch Company',
        ]);

        return [$user, $company];
    }
}
