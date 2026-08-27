<?php

namespace Tests\Feature;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserBUJP;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_profile_can_be_read_and_updated(): void
    {
        $user = User::create([
            'name' => 'Budi', 'email' => 'budi@example.com', 'phone_number' => '081234567890',
            'google_id' => '', 'password' => 'password', 'role' => 'satpam', 'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        Security::create(['user_security_id' => $relation->id, 'name' => 'Budi']);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('data.profile.type', 'security')
            ->assertJsonPath('data.profile.data.name', 'Budi');

        $this->withToken($token)->patchJson('/api/profile', [
            'birth_place' => 'Balikpapan', 'is_shift_agree' => false,
        ])->assertOk()
            ->assertJsonPath('data.profile.data.birth_place', 'Balikpapan')
            ->assertJsonPath('data.profile.data.is_shift_agree', false);
    }

    public function test_company_and_bujp_profiles_are_role_scoped(): void
    {
        foreach ([
            ['company', UserCompany::class, Company::class],
            ['bujp', UserBUJP::class, BUJP::class],
        ] as [$role, $relationClass, $profileClass]) {
            $user = User::create([
                'name' => 'Business', 'email' => $role.'@example.com', 'google_id' => '',
                'password' => 'password', 'role' => $role, 'status' => 'active',
            ]);
            $relation = $relationClass::create(['user_id' => $user->id]);
            $foreignKey = $role === 'company' ? 'user_company_id' : 'user_b_u_j_p_id';
            $profileClass::create([$foreignKey => $relation->id]);
            $token = app(TokenService::class)->issue($user)['access_token'];

            $this->withToken($token)->patchJson('/api/profile', ['company_name' => 'Updated'])
                ->assertOk()
                ->assertJsonPath('data.profile.data.company_name', 'Updated');
        }
    }
}
