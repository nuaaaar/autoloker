<?php

namespace Tests\Feature\Api;

use App\Models\MasterCategoryCertificate;
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

    public function test_certificate_crud_returns_sample_shape_and_scopes_uuid_resources(): void
    {
        $user = User::create([
            'name' => 'CRUD User',
            'email' => 'certificate-crud@example.com',
            'phone_number' => '081234567892',
            'google_id' => 'certificate-crud-google-id',
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        Security::create(['user_security_id' => $relation->id, 'name' => 'CRUD User']);
        MasterCategoryCertificate::create(['title' => 'Teknis Operasional']);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $payload = [
            'title' => 'Satpam Garda Pratama',
            'publisher' => 'BNSP',
            'certificate_number' => 'BNSP-XXX-000',
            'category' => 'Teknis Operasional',
            'publish_date' => '2026-09-18',
            'expired_date' => '2030-12-18',
            'is_badge' => 1,
        ];

        $created = $this->withToken($token)
            ->postJson('/api/security-certificates', $payload)
            ->assertCreated()
            ->assertJsonPath('data.security_certificate.title', 'Satpam Garda Pratama')
            ->assertJsonPath('data.security_certificate.publisher', 'BNSP')
            ->assertJsonPath('data.security_certificate.category', 'Teknis Operasional')
            ->assertJsonPath('data.security_certificate.is_badge', 1);

        $uuid = $created->json('data.security_certificate.uuid');

        $this->withToken($token)
            ->getJson("/api/security-certificates/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.security_certificate.uuid', $uuid);

        $this->withToken($token)
            ->patchJson("/api/security-certificates/{$uuid}", ['title' => 'Updated Certificate'])
            ->assertOk()
            ->assertJsonPath('data.security_certificate.title', 'Updated Certificate');

        $this->withToken($token)
            ->getJson('/api/security-certificates/00000000-0000-0000-0000-000000000000')
            ->assertNotFound();

        $this->withToken($token)
            ->deleteJson("/api/security-certificates/{$uuid}")
            ->assertOk()
            ->assertJsonPath('message', 'Security certificate deleted successfully.');

        $this->assertDatabaseMissing('security_certificates', ['uuid' => $uuid]);
    }
}
