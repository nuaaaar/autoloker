<?php

namespace Tests\Feature\Api;

use App\Models\Security;
use App\Models\SecurityHistory;
use App\Models\User;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_index_orders_by_newest_start_date(): void
    {
        $user = User::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone_number' => '081234567890',
            'google_id' => '',
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        $security = Security::create(['user_security_id' => $relation->id, 'name' => 'Budi']);

        $security->histories()->create([
            'position' => 'Senior',
            'company_name' => 'Newest Company',
            'start_date' => '2025-01-01',
        ]);
        $security->histories()->create([
            'position' => 'Junior',
            'company_name' => 'Older Company',
            'start_date' => '2024-01-01',
        ]);

        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->getJson('/api/security-histories')
            ->assertOk()
            ->assertJsonPath('data.security_histories.0.company_name', 'Newest Company')
            ->assertJsonPath('data.security_histories.0.start_date', '2025-01-01')
            ->assertJsonPath('data.security_histories.1.company_name', 'Older Company');
    }
}
