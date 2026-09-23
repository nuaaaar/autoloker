<?php

namespace Tests\Feature\Api;

use App\Models\BUJP;
use App\Models\Training;
use App\Models\TrainingApplication;
use App\Models\User;
use App\Models\UserBUJP;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OwnedTrainingManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedLocations();
    }

    public function test_post_creates_draft_with_canonical_body_and_location_header(): void
    {
        [, $bujp, $token] = $this->bujpAccount('training-create@example.com', 'Aman Training');

        $response = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload());

        $response->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Training created successfully.')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'training' => [
                        'uuid',
                        'title',
                        'provider',
                        'bujp' => ['id', 'company_name'],
                        'company',
                        'status',
                        'poster',
                        'category',
                        'level',
                        'is_certificate',
                        'tags',
                        'description',
                        'start_date',
                        'end_date',
                        'duration_day',
                        'total_jp',
                        'training_mode',
                        'province',
                        'city',
                        'address',
                        'syllabus',
                        'requirements',
                        'instructor',
                        'quota',
                        'price',
                        'registered_count',
                        'approved_count',
                        'progress',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
            ->assertJsonPath('data.training.title', 'Pelatihan Dasar Satpam')
            ->assertJsonPath('data.training.provider', 'Aman Training')
            ->assertJsonPath('data.training.bujp.id', $bujp->id)
            ->assertJsonPath('data.training.bujp.company_name', 'Aman Training')
            ->assertJsonPath('data.training.company', null)
            ->assertJsonPath('data.training.status', 'draft')
            ->assertJsonPath('data.training.province', 'KALIMANTAN TIMUR')
            ->assertJsonPath('data.training.city', 'BALIKPAPAN')
            ->assertJsonPath('data.training.duration_day', 3)
            ->assertJsonPath('data.training.progress', 0);

        $uuid = $response->json('data.training.uuid');
        $response->assertHeader('Location', route('api.company.trainings.show', ['uuid' => $uuid]));
        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'b_u_j_p_id' => $bujp->id,
            'company_id' => null,
            'status' => 'draft',
            'duration_day' => 3,
        ]);
    }

    public function test_patch_updates_only_submitted_fields_and_replaces_arrays(): void
    {
        [, , $token] = $this->bujpAccount('training-patch@example.com', 'Patch Training');
        $created = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.training.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/trainings/{$uuid}", [
                'title' => 'Pelatihan Dasar Satpam Updated',
                'tags' => ['Evakuasi'],
                'address' => null,
            ])
            ->assertOk()
            ->assertJsonPath('data.training.title', 'Pelatihan Dasar Satpam Updated')
            ->assertJsonPath('data.training.tags', ['Evakuasi'])
            ->assertJsonPath('data.training.address', null)
            ->assertJsonPath('data.training.category', 'Keamanan')
            ->assertJsonPath('data.training.duration_day', 3)
            ->assertJsonPath('data.training.status', 'draft');

        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'title' => 'Pelatihan Dasar Satpam Updated',
            'category' => 'Keamanan',
            'address' => null,
            'tags' => json_encode(['Evakuasi']),
            'duration_day' => 3,
        ]);
    }

    public function test_duration_day_is_calculated_inclusively_from_dates(): void
    {
        [, , $token] = $this->bujpAccount('training-duration@example.com', 'Duration Training');

        $response = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload([
                'start_date' => '2026-11-10',
                'end_date' => '2026-11-10',
                'duration_day' => 99,
            ]));

        $response->assertCreated()->assertJsonPath('data.training.duration_day', 1);
        $this->assertDatabaseHas('trainings', ['duration_day' => 1]);
    }

    public function test_post_returns_per_field_validation_errors(): void
    {
        [, , $token] = $this->bujpAccount('training-validation@example.com', 'Validation Training');

        $response = $this->withToken($token)->postJson('/api/company/trainings', [
            'title' => 'No',
            'category' => 'Keamanan',
            'level' => 'Dasar',
            'start_date' => '2026-10-03',
            'end_date' => '2026-10-01',
            'total_jp' => 0,
            'training_mode' => 'onsite',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'BANDUNG',
            'tags' => ['K3', 'k3'],
            'syllabus' => [''],
            'quota' => 0,
            'price' => -1,
        ]);

        $response->assertUnprocessable()
            ->assertJsonPath('status', false)
            ->assertJsonValidationErrors([
                'title',
                'end_date',
                'total_jp',
                'training_mode',
                'city',
                'tags.1',
                'syllabus.0',
                'quota',
                'price',
            ]);
        $this->assertDatabaseCount('trainings', 0);
    }

    public function test_patch_rejects_quota_below_active_participants(): void
    {
        [, , $token] = $this->bujpAccount('training-quota@example.com', 'Quota Training');
        $created = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload(['quota' => 3]))
            ->assertCreated();
        $training = Training::where('uuid', $created->json('data.training.uuid'))->firstOrFail();

        foreach (['pending', 'approved', 'approved'] as $status) {
            TrainingApplication::create([
                'training_id' => $training->id,
                'security_id' => null,
                'status' => $status,
            ]);
        }

        $this->withToken($token)
            ->patchJson("/api/company/trainings/{$training->uuid}", ['quota' => 2])
            ->assertStatus(409)
            ->assertJsonValidationErrors(['quota']);

        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
            'quota' => 3,
        ]);
    }

    public function test_training_ownership_isolation_returns_not_found(): void
    {
        [, , $ownerToken] = $this->bujpAccount('training-owner@example.com', 'Owner Training');
        [, , $otherToken] = $this->bujpAccount('training-other@example.com', 'Other Training');
        $created = $this->withToken($ownerToken)
            ->postJson('/api/company/trainings', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.training.uuid');

        $this->withToken($otherToken)
            ->getJson("/api/company/trainings/{$uuid}")
            ->assertNotFound();
        $this->withToken($otherToken)
            ->patchJson("/api/company/trainings/{$uuid}", ['title' => 'Hijacked'])
            ->assertNotFound();
        $this->withToken($otherToken)
            ->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertNotFound();
    }

    public function test_response_uses_training_resource_key_after_submit_action(): void
    {
        [, , $token] = $this->bujpAccount('training-submit@example.com', 'Submit Training');

        $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload(['workflow_action' => 'submit']))
            ->assertCreated()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.training.status', 'submitted')
            ->assertJsonMissingPath('data.trainings');
    }

    public function test_patch_rejects_immutable_owner_status_timestamp_and_counter_fields(): void
    {
        [, , $token] = $this->bujpAccount('training-immutable@example.com', 'Immutable Training');
        $created = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.training.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/trainings/{$uuid}", [
                'uuid' => 'forged-uuid',
                'b_u_j_p_id' => 999999,
                'provider' => 'Forged Provider',
                'status' => 'submitted',
                'created_at' => '2026-01-01 00:00:00',
                'registered_count' => 99,
                'total_clicked' => 99,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'uuid',
                'b_u_j_p_id',
                'provider',
                'status',
                'created_at',
                'registered_count',
                'total_clicked',
            ]);

        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'status' => 'draft',
            'duration_day' => 3,
            'total_clicked' => 0,
        ]);
    }

    public function test_poster_accepts_public_storage_key_and_multipart_file_without_internal_path(): void
    {
        [, , $token] = $this->bujpAccount('training-poster@example.com', 'Poster Training');

        $pathResponse = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload([
                'poster' => 'training/posters/existing.png',
            ]))
            ->assertCreated();
        $this->assertSame(
            'training/posters/existing.png',
            $pathResponse->json('data.training.poster'),
        );

        $fileResponse = $this->withToken($token)->post(
            '/api/company/trainings',
            $this->payload(['poster' => UploadedFile::fake()->create('poster.jpg', 10, 'image/jpeg')]),
            ['Accept' => 'application/json'],
        );
        $fileResponse->assertCreated();
        $storedPoster = $fileResponse->json('data.training.poster');
        $this->assertIsString($storedPoster);
        $this->assertStringStartsWith('training/posters/', $storedPoster);
        $this->assertFalse(str_starts_with($storedPoster, '/'));
        $this->assertFalse(str_contains($storedPoster, 'storage/app'));
    }

    public function test_non_bujp_role_cannot_use_training_management_endpoints(): void
    {
        $user = User::create([
            'name' => 'Security User',
            'email' => 'training-security@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload())
            ->assertNotFound();
    }

    public function test_submit_endpoint_preserves_draft_when_completion_validation_fails(): void
    {
        [, , $token] = $this->bujpAccount('training-submit-invalid@example.com', 'Incomplete Training');
        $created = $this->withToken($token)
            ->postJson('/api/company/trainings', ['title' => 'Draft Only'])
            ->assertCreated();
        $uuid = $created->json('data.training.uuid');

        $this->withToken($token)
            ->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'category',
                'level',
                'description',
                'start_date',
                'end_date',
                'total_jp',
                'training_mode',
                'province',
                'city',
                'address',
                'syllabus',
                'requirements',
                'quota',
            ]);

        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'status' => 'draft',
        ]);
    }

    /** @return array<string, mixed> */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Pelatihan Dasar Satpam',
            'category' => 'Keamanan',
            'level' => 'Dasar',
            'is_certificate' => true,
            'tags' => ['K3', 'Patroli'],
            'description' => 'Pelatihan dasar untuk calon petugas keamanan.',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-03',
            'total_jp' => 24,
            'training_mode' => 'online',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'BALIKPAPAN',
            'address' => 'Platform pembelajaran BUJP Aman',
            'syllabus' => ['Pengenalan keamanan', 'Teknik patroli'],
            'requirements' => ['Memiliki KTP', 'Sehat jasmani'],
            'instructor' => 'Budi Santoso',
            'quota' => 20,
            'price' => 0,
            'poster' => null,
            'workflow_action' => 'save_draft',
        ], $overrides);
    }

    /** @return array{0: User, 1: BUJP, 2: string} */
    private function bujpAccount(string $email, string $name): array
    {
        $user = User::create([
            'name' => $name.' User',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'bujp',
            'status' => 'active',
        ]);
        $userBujp = UserBUJP::create(['user_id' => $user->id]);
        $bujp = BUJP::create([
            'user_b_u_j_p_id' => $userBujp->id,
            'company_name' => $name,
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        return [$user, $bujp, $token];
    }

    private function seedLocations(): void
    {
        $timestamp = now();

        DB::table('indonesia_provinces')->insert([
            'code' => '64',
            'name' => 'KALIMANTAN TIMUR',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_provinces')->insert([
            'code' => '32',
            'name' => 'JAWA BARAT',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_cities')->insert([
            'code' => '6471',
            'province_code' => '64',
            'name' => 'BALIKPAPAN',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_cities')->insert([
            'code' => '3273',
            'province_code' => '32',
            'name' => 'BANDUNG',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
