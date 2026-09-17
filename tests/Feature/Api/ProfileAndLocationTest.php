<?php

namespace Tests\Feature\Api;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\Security;
use App\Models\User;
use App\Models\UserBUJP;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProfileAndLocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_profile_role_supports_partial_location_updates(): void
    {
        $this->seedLocations();

        foreach ([
            ['satpam', 'security@example.com', 'security', 'Aceh Security', UserSecurity::class, Security::class, 'user_security_id'],
            ['company', 'company@example.com', 'company', 'Aceh Company', UserCompany::class, Company::class, 'user_company_id'],
            ['bujp', 'bujp@example.com', 'bujp', 'Aceh BUJP', UserBUJP::class, BUJP::class, 'user_b_u_j_p_id'],
        ] as [$role, $email, $apiType, $companyName, $relationClass, $profileClass, $foreignKey]) {
            $user = User::create([
                'name' => $apiType.' user',
                'email' => $email,
                'google_id' => '',
                'password' => 'password',
                'role' => $role,
                'status' => 'active',
            ]);
            $relation = $relationClass::create(['user_id' => $user->id]);
            $profileClass::create([$foreignKey => $relation->id, 'company_name' => $companyName]);
            $token = app(TokenService::class)->issue($user)['access_token'];

            $payload = [
                'province' => '11',
                'city' => '1101',
                'district' => '110101',
                'village' => '1101012001',
            ];
            if ($role === 'satpam') {
                $payload['birth_place'] = 'Banda Aceh';
                $payload['height'] = '170';
            } elseif ($role === 'company') {
                $payload['description'] = 'Updated company description';
                $payload['postal_code'] = '23111';
            } else {
                $payload['sio_number'] = 'SIO-2026-001';
                $payload['postal_code'] = '23111';
            }

            $response = $this->withToken($token)->patchJson('/api/profile', $payload);

            $response->assertOk()
                ->assertJsonPath('data.profile.type', $apiType)
                ->assertJsonPath('data.profile.data.company_name', $companyName)
                ->assertJsonPath('data.profile.data.province', 'Aceh')
                ->assertJsonPath('data.profile.data.province_code', '11')
                ->assertJsonPath('data.profile.data.city', 'Banda Aceh')
                ->assertJsonPath('data.profile.data.city_code', '1101')
                ->assertJsonPath('data.profile.data.district', 'Baiturrahman')
                ->assertJsonPath('data.profile.data.district_code', '110101')
                ->assertJsonPath('data.profile.data.village', 'Ateuk Pahlawan')
                ->assertJsonPath('data.profile.data.village_code', '1101012001');

            if ($role === 'satpam') {
                $response->assertJsonPath('data.profile.data.birth_place', 'Banda Aceh')
                    ->assertJsonPath('data.profile.data.height', '170');
            } elseif ($role === 'company') {
                $response->assertJsonPath('data.profile.data.description', 'Updated company description')
                    ->assertJsonPath('data.profile.data.postal_code', '23111');
            } else {
                $response->assertJsonPath('data.profile.data.sio_number', 'SIO-2026-001')
                    ->assertJsonPath('data.profile.data.postal_code', '23111');
            }
        }
    }

    public function test_full_profile_get_returns_location_names_and_codes(): void
    {
        $this->seedLocations();
        $user = User::create([
            'name' => 'Profile User',
            'email' => 'profile-get@example.com',
            'google_id' => '',
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        $profile = Security::create([
            'user_security_id' => $relation->id,
            'province' => 'Aceh',
            'city' => 'Banda Aceh',
            'district' => 'Baiturrahman',
            'village' => 'Ateuk Pahlawan',
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('data.profile.data.province', 'Aceh')
            ->assertJsonPath('data.profile.data.province_code', '11')
            ->assertJsonPath('data.profile.data.city', 'Banda Aceh')
            ->assertJsonPath('data.profile.data.city_code', '1101')
            ->assertJsonPath('data.profile.data.district', 'Baiturrahman')
            ->assertJsonPath('data.profile.data.district_code', '110101')
            ->assertJsonPath('data.profile.data.village', 'Ateuk Pahlawan')
            ->assertJsonPath('data.profile.data.village_code', '1101012001');

        $this->assertDatabaseHas('securities', [
            'id' => $profile->id,
            'province_code' => '11',
            'city_code' => '1101',
            'district_code' => '110101',
            'village_code' => '1101012001',
        ]);
    }

    public function test_location_master_endpoints_return_code_and_name(): void
    {
        $this->seedLocations();
        $user = User::create([
            'name' => 'Location User',
            'email' => 'locations@example.com',
            'google_id' => '',
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->getJson('/api/locations/provinces')
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonFragment(['code' => '11', 'name' => 'Aceh']);

        $this->withToken($token)->getJson('/api/locations/cities?province_code=11')
            ->assertOk()
            ->assertJsonFragment(['code' => '1101', 'name' => 'Banda Aceh']);

        $this->withToken($token)->getJson('/api/locations/districts?city_code=1101')
            ->assertOk()
            ->assertJsonFragment(['code' => '110101', 'name' => 'Baiturrahman']);

        $this->withToken($token)->getJson('/api/locations/villages?district_code=110101')
            ->assertOk()
            ->assertJsonFragment(['code' => '1101012001', 'name' => 'Ateuk Pahlawan']);
    }

    private function seedLocations(): void
    {
        $timestamp = now();

        DB::table('indonesia_provinces')->insert([
            'code' => '11',
            'name' => 'Aceh',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_cities')->insert([
            'code' => '1101',
            'province_code' => '11',
            'name' => 'Banda Aceh',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_districts')->insert([
            'code' => '110101',
            'city_code' => '1101',
            'name' => 'Baiturrahman',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_villages')->insert([
            'code' => '1101012001',
            'district_code' => '110101',
            'name' => 'Ateuk Pahlawan',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
