<?php

namespace Tests\Feature\Api;

use App\Models\Security;
use App\Models\User;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityCertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_certificate_index_returns_only_authenticated_security_certificates_ordered_by_expiry(): void
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

        $otherUser = User::create([
            'name' => 'Other User',
            'email' => 'other@example.com',
            'phone_number' => '081234567891',
            'google_id' => 'other-google-id',
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $otherRelation = UserSecurity::create(['user_id' => $otherUser->id]);
        $otherSecurity = Security::create(['user_security_id' => $otherRelation->id, 'name' => 'Other User']);

        $security->certificates()->create([
            'title' => 'Expiring Later',
            'expired_date' => '2026-12-31',
        ]);
        $security->certificates()->create([
            'title' => 'Expiring Sooner',
            'expired_date' => '2026-01-31',
        ]);
        $otherSecurity->certificates()->create([
            'title' => 'Other Security Certificate',
            'expired_date' => '2026-02-28',
        ]);

        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)->getJson('/api/security-certificates')
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonCount(2, 'data.security_certificates')
            ->assertJsonPath('data.security_certificates.0.title', 'Expiring Sooner')
            ->assertJsonPath('data.security_certificates.1.title', 'Expiring Later')
            ->assertJsonMissing(['title' => 'Other Security Certificate']);
    }
}
