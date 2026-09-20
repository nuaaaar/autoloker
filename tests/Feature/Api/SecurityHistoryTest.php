<?php

namespace Tests\Feature\Api;

use App\Models\Security;
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
            'end_date' => '2025-12-31',
        ]);
        $security->histories()->create([
            'position' => 'Junior',
            'company_name' => 'Older Company',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);

        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->getJson('/api/security-histories')
            ->assertOk()
            ->assertJsonPath('data.security_histories.0.company_name', 'Newest Company')
            ->assertJsonPath('data.security_histories.0.start_date', '2025-01-01')
            ->assertJsonPath('data.security_histories.0.is_current', false)
            ->assertJsonPath('data.security_histories.1.company_name', 'Older Company');
    }

    public function test_history_crud_validates_end_date_and_returns_boolean_current_flag(): void
    {
        $user = User::create([
            'name' => 'CRUD User',
            'email' => 'crud@example.com',
            'phone_number' => '081234567891',
            'google_id' => '',
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        Security::create(['user_security_id' => $relation->id, 'name' => 'CRUD User']);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->postJson('/api/security-histories', [
            'start_date' => '2025-01-01',
            'is_current' => false,
            'end_date' => null,
        ])->assertUnprocessable()->assertJsonValidationErrors('end_date');

        $created = $this->withToken($token)->postJson('/api/security-histories', [
            'start_date' => '2025-01-01',
            'is_current' => true,
            'end_date' => null,
        ])->assertCreated()
            ->assertJsonPath('data.security_history.is_current', true)
            ->assertJsonPath('data.security_history.end_date', null);

        $uuid = $created->json('data.security_history.uuid');

        $this->withToken($token)->patchJson("/api/security-histories/{$uuid}", [
            'is_current' => false,
        ])->assertUnprocessable()->assertJsonValidationErrors('end_date');

        $this->withToken($token)->patchJson("/api/security-histories/{$uuid}", [
            'is_current' => false,
            'end_date' => '2025-12-31',
        ])->assertOk()
            ->assertJsonPath('data.security_history.is_current', false);

        $this->withToken($token)->getJson("/api/security-histories/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.security_history.is_current', false);
    }
}
