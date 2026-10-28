<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Training;
use App\Models\TrainingApplication;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\MasterCategoryCertificate;
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
        MasterCategoryCertificate::create([
            'title' => 'Keamanan',
            'category' => 'security',
            'level' => 1,
            'parent_id' => null,
            'is_tuk' => false,
        ]);
        $this->seedLocations();
    }

    public function test_training_taxonomy_and_discount_validate_and_persist_through_mutations(): void
    {
        [, , $token] = $this->companyAccount('training-taxonomy@example.com', 'Taxonomy Training');
        $root = MasterCategoryCertificate::query()->where('title', 'Keamanan')->firstOrFail();
        $child = MasterCategoryCertificate::create([
            'title' => 'Patroli',
            'category' => 'security',
            'level' => 2,
            'parent_id' => $root->id,
            'is_tuk' => true,
        ]);

        foreach (['mandiri', 'sewaktu', 'tempat kerja'] as $tuk) {
            $response = $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
                'sub_category' => $child->title,
                'tuk' => $tuk,
                'price' => 750000,
                'discount' => 12.5,
            ]))->assertCreated()->assertJsonPath('data.training.status', 'draft');
            $training = Training::where('uuid', $response->json('data.training.uuid'))->firstOrFail();
            $this->assertSame('Keamanan', $training->category);
            $this->assertSame('Patroli', $training->sub_category);
            $this->assertSame($tuk, $training->tuk);
            $this->assertSame('750000', (string) $training->price);
            $this->assertEquals(12.5, (float) $training->discount);
        }

        $created = $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'sub_category' => 'Patroli',
            'tuk' => 'mandiri',
            'price' => 750000,
            'discount' => 12.5,
        ]))->assertCreated();
        $uuid = $created->json('data.training.uuid');
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", ['discount' => 25])->assertOk();
        $training = Training::where('uuid', $uuid)->firstOrFail();
        $this->assertSame('Patroli', $training->sub_category);
        $this->assertSame('mandiri', $training->tuk);
        $this->assertSame('750000', (string) $training->price);
        $this->assertEquals(25, (float) $training->discount);

        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", ['category' => 'unknown'])
            ->assertUnprocessable()->assertJsonValidationErrors('category');
        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'category' => 'Keamanan',
            'sub_category' => 'Patroli',
            'tuk' => 'mandiri',
            'discount' => '25.00',
        ]);

        foreach ([
            ['discount' => -1],
            ['discount' => 101],
            ['discount' => 'abc'],
            ['discount' => 1.234],
            ['discount' => []],
        ] as $invalid) {
            $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", $invalid)
                ->assertUnprocessable()->assertJsonValidationErrors('discount');
        }

        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", ['discount' => null])
            ->assertOk();
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'discount' => '0.00']);
    }

    public function test_post_creates_draft_with_canonical_body_and_location_header(): void
    {
        [$user, $company, $token] = $this->companyAccount('training-create@example.com', 'Aman Training');

        $response = $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload());

        $response->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonPath('status', true)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'training' => [
                        'uuid',
                        'title',
                        'provider',
                        'company' => ['id', 'company_name'],
                        'company',
                        'status',
                        'poster',
                        'category',
                        'is_certificate',
                        'sub_category',
                        'tuk',
                        'discount',
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
            ->assertJsonPath('data.training.company.id', $company->id)
            ->assertJsonPath('data.training.company.company_name', 'Aman Training')
            ->assertJsonPath('data.training.bujp', null)
            ->assertJsonPath('data.training.status', 'draft')
            ->assertJsonPath('data.training.province', 'KALIMANTAN TIMUR')
            ->assertJsonPath('data.training.city', 'BALIKPAPAN')
            ->assertJsonPath('data.training.duration_day', 3)
            ->assertJsonPath('data.training.progress', 0)
            ->assertJsonPath('data.training.sub_category', null)
            ->assertJsonPath('data.training.tuk', null)
            ->assertJsonPath('data.training.discount', 0);

        $uuid = $response->json('data.training.uuid');
        $response->assertHeader('Location', route('api.company.trainings.show', ['uuid' => $uuid]));
        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'company_id' => $company->id,
            'b_u_j_p_id' => null,
            'status' => 'draft',
            'duration_day' => 3,
        ]);
    }
    public function test_taxonomy_rules_gate_submission_and_reject_invalid_master_titles(): void
    {
        [, , $token] = $this->companyAccount('training-taxonomy-submit@example.com', 'Taxonomy Submit');
        $securityRoot = MasterCategoryCertificate::query()->where('title', 'Keamanan')->firstOrFail();
        $securityChild = MasterCategoryCertificate::create([
            'title' => 'Patroli',
            'category' => 'security',
            'level' => 2,
            'parent_id' => $securityRoot->id,
            'is_tuk' => true,
        ]);
        $csRoot = MasterCategoryCertificate::create([
            'title' => 'Kebersihan',
            'category' => 'cs',
            'level' => 1,
            'parent_id' => null,
            'is_tuk' => false,
        ]);

        foreach ([
            ['category' => 'Patroli', 'category_role' => 'security'],
            ['category' => 'Kebersihan', 'category_role' => 'security'],
        ] as $invalid) {
            $this->withToken($token)->postJson('/api/company/trainings', $this->payload($invalid))
                ->assertUnprocessable()->assertJsonValidationErrors('category');
        }
        $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'sub_category' => 'Other child',
        ]))->assertUnprocessable()->assertJsonValidationErrors('sub_category');

        $draft = $this->withToken($token)->postJson('/api/company/trainings', $this->payload())
            ->assertCreated();
        $uuid = $draft->json('data.training.uuid');
        $this->withToken($token)->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertUnprocessable()->assertJsonValidationErrors('sub_category');
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'status' => 'draft']);

        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", [
            'sub_category' => 'Patroli',
        ])->assertOk();
        $this->withToken($token)->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertUnprocessable()->assertJsonValidationErrors('tuk');
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", ['tuk' => 'mandiri'])
            ->assertOk();
        $this->withToken($token)->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertOk()->assertJsonPath('data.training.status', 'submitted');

        $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'category' => $csRoot->title,
            'category_role' => 'cs',
            'workflow_action' => 'submit',
            'tuk' => 'mandiri',
        ]))->assertUnprocessable()->assertJsonValidationErrors('tuk');

        $falseRoot = MasterCategoryCertificate::create([
            'title' => 'Dukungan',
            'category' => 'security',
            'level' => 1,
            'parent_id' => null,
            'is_tuk' => false,
        ]);
        $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'category' => $falseRoot->title,
            'tuk' => 'mandiri',
        ]))->assertUnprocessable()->assertJsonValidationErrors('tuk');
    }

    public function test_discount_defaults_and_price_rules_remain_distinct(): void
    {
        [, , $token] = $this->companyAccount('training-price-discount@example.com', 'Price Training');
        $created = $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'price' => 0,
        ]))->assertCreated();
        $uuid = $created->json('data.training.uuid');
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'price' => 0, 'discount' => 0]);

        foreach ([-1, 1.5, []] as $invalidPrice) {
            $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", ['price' => $invalidPrice])
                ->assertUnprocessable()->assertJsonValidationErrors('price');
        }
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", ['price' => null])
            ->assertOk();
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'price' => null, 'discount' => 0]);
    }

    public function test_post_patch_and_submit_preserve_optional_district_and_village(): void
    {
        [, , $token] = $this->companyAccount('district_and_village@example.com', 'Location Training');
        $response = $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'district' => 'Balikpapan Selatan',
            'village' => 'Sepinggan',
        ]))->assertCreated();
        $uuid = $response->json('data.training.uuid');
        $response->assertJsonStructure(['data' => ['training' => ['district', 'village']]]);
        $response->assertJsonPath('data.training.district', 'Balikpapan Selatan')
            ->assertJsonPath('data.training.village', 'Sepinggan');
        $this->assertDatabaseHas('trainings', [
            'uuid' => $uuid,
            'district' => 'Balikpapan Selatan',
            'village' => 'Sepinggan',
        ]);

        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", [
            'district' => 'Balikpapan Utara',
        ])->assertOk()
            ->assertJsonPath('data.training.district', 'Balikpapan Utara')
            ->assertJsonPath('data.training.village', 'Sepinggan');
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", [
            'title' => 'Pelatihan Updated',
        ])->assertOk()
            ->assertJsonPath('data.training.district', 'Balikpapan Utara')
            ->assertJsonPath('data.training.village', 'Sepinggan');
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", [
            'district' => null,
            'village' => null,
        ])->assertOk()
            ->assertJsonPath('data.training.district', null)
            ->assertJsonPath('data.training.village', null);
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'district' => null, 'village' => null]);

        $this->withToken($token)->postJson('/api/company/trainings', $this->payload())
            ->assertCreated()->assertJsonStructure(['data' => ['training' => ['district', 'village']]]);
        $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'district' => [],
            'village' => str_repeat('x', 256),
        ]))->assertUnprocessable()->assertJsonValidationErrors(['district', 'village']);
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", [
            'district' => str_repeat('d', 256),
            'village' => 123,
        ])->assertUnprocessable()->assertJsonValidationErrors(['district', 'village']);
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'district' => null, 'village' => null]);

        $boundary = $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'district' => str_repeat('d', 255),
            'village' => str_repeat('v', 255),
        ]))->assertCreated();
        $boundary->assertJsonPath('data.training.district', str_repeat('d', 255))
            ->assertJsonPath('data.training.village', str_repeat('v', 255));

        $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
            'district' => 'Balikpapan Selatan',
            'village' => 'Sepinggan',
            'workflow_action' => 'submit',
        ]))->assertCreated()
            ->assertJsonPath('data.training.district', 'Balikpapan Selatan')
            ->assertJsonPath('data.training.village', 'Sepinggan');
    }


    public function test_patch_updates_only_submitted_fields_and_replaces_arrays(): void
    {
        [, , $token] = $this->companyAccount('training-patch@example.com', 'Patch Training');
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
        [, , $token] = $this->companyAccount('training-duration@example.com', 'Duration Training');

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
        [, , $token] = $this->companyAccount('training-validation@example.com', 'Validation Training');

        $response = $this->withToken($token)->postJson('/api/company/trainings', [
            'title' => 'No',
            'category' => 'Keamanan',
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
        [, , $token] = $this->companyAccount('training-quota@example.com', 'Quota Training');
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
        [, , $ownerToken] = $this->companyAccount('training-owner@example.com', 'Owner Training');
        [, , $otherToken] = $this->companyAccount('training-other@example.com', 'Other Training');
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
        [, , $token] = $this->companyAccount('training-submit@example.com', 'Submit Training');

        $this->withToken($token)
            ->postJson('/api/company/trainings', $this->payload(['workflow_action' => 'submit']))
            ->assertCreated()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.training.status', 'submitted')
            ->assertJsonMissingPath('data.trainings');
    }

    public function test_patch_rejects_immutable_owner_status_timestamp_and_counter_fields(): void
    {
        [, , $token] = $this->companyAccount('training-immutable@example.com', 'Immutable Training');
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
        [, , $token] = $this->companyAccount('training-poster@example.com', 'Poster Training');

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

    public function test_worker_and_bujp_roles_cannot_use_training_management_endpoints(): void
    {
        foreach (['satpam', 'cs', 'bujp'] as $role) {
            $user = User::create([
                'name' => 'Non Company User',
                'email' => "non-company-training-{$role}@example.com",
                'google_id' => null,
                'password' => 'password',
                'role' => $role,
                'status' => 'active',
            ]);
            $token = app(TokenService::class)->issue($user)['access_token'];

            $this->withToken($token)
                ->postJson('/api/company/trainings', $this->payload())
                ->assertNotFound();
        }
    }

    public function test_create_ignores_legacy_level_and_submit_does_not_require_it(): void
    {
        [, $company, $token] = $this->companyAccount('training-no-level@example.com', 'No Level Training');
        foreach ([
            ['workflow_action' => 'save_draft', 'legacy' => 'Lanjutan', 'status' => 'draft'],
            ['workflow_action' => 'submit', 'legacy' => ['legacy'], 'status' => 'submitted'],
        ] as $case) {
            $response = $this->withToken($token)->postJson('/api/company/trainings', $this->payload([
                'workflow_action' => $case['workflow_action'], 'level' => $case['legacy'],
            ]))->assertCreated()->assertJsonPath('data.training.status', $case['status'])
                ->assertJsonMissingPath('data.training.level')
                ->assertJsonPath('data.training.company.id', $company->id);
            $this->assertDatabaseHas('trainings', [
                'uuid' => $response->json('data.training.uuid'), 'company_id' => $company->id, 'level' => null,
            ]);
        }
    }

    public function test_patch_ignores_legacy_level_without_changing_historical_value(): void
    {
        [, , $token] = $this->companyAccount('training-level-patch@example.com', 'Historical Level');
        $created = $this->withToken($token)->postJson('/api/company/trainings', $this->payload())->assertCreated();
        $uuid = $created->json('data.training.uuid');
        Training::where('uuid', $uuid)->update(['level' => 'Lanjutan']);
        $this->withToken($token)->patchJson("/api/company/trainings/{$uuid}", [
            'title' => 'Pelatihan Diperbarui Tanpa Level', 'level' => ['legacy'],
        ])->assertOk()->assertJsonMissingPath('data.training.level')
            ->assertJsonPath('data.training.title', 'Pelatihan Diperbarui Tanpa Level');
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'level' => 'Lanjutan']);
        $this->withToken($token)->getJson("/api/company/trainings/{$uuid}")
            ->assertOk()->assertJsonMissingPath('data.training.level');
        $this->withToken($token)->getJson('/api/company/trainings')
            ->assertOk()->assertJsonMissingPath('data.trainings.0.level');
    }

    public function test_owned_search_does_not_match_historical_level(): void
    {
        [, , $token] = $this->companyAccount('training-level-search@example.com', 'Search Training');
        $created = $this->withToken($token)->postJson('/api/company/trainings', $this->payload())->assertCreated();
        $uuid = $created->json('data.training.uuid');
        Training::where('uuid', $uuid)->update(['level' => 'Lanjutan']);
        $this->withToken($token)->getJson('/api/company/trainings?search=Lanjutan')
            ->assertOk()->assertJsonPath('data.pagination.total', 0);
        $this->withToken($token)->getJson('/api/company/trainings?search=Pelatihan%20Dasar%20Satpam')
            ->assertOk()->assertJsonPath('data.pagination.total', 1)
            ->assertJsonPath('data.trainings.0.uuid', $uuid)->assertJsonMissingPath('data.trainings.0.level');
    }

    public function test_complete_draft_submits_without_level_but_still_requires_syllabus(): void
    {
        [, , $token] = $this->companyAccount('training-level-submit@example.com', 'Submit No Level');
        $created = $this->withToken($token)->postJson('/api/company/trainings', $this->payload())->assertCreated();
        $uuid = $created->json('data.training.uuid');
        $this->withToken($token)->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertOk()->assertJsonPath('data.training.status', 'submitted')
            ->assertJsonMissingPath('data.training.level');
        $this->assertDatabaseHas('trainings', ['uuid' => $uuid, 'level' => null, 'status' => 'submitted']);
        $incomplete = $this->withToken($token)->postJson('/api/company/trainings', $this->payload(['syllabus' => []]))->assertCreated();
        $incompleteUuid = $incomplete->json('data.training.uuid');
        $this->withToken($token)->postJson("/api/company/trainings/{$incompleteUuid}/submit")
            ->assertUnprocessable()->assertJsonValidationErrors(['syllabus'])->assertJsonMissingValidationErrors(['level']);
        $this->assertDatabaseHas('trainings', ['uuid' => $incompleteUuid, 'status' => 'draft']);
    }

    public function test_submit_endpoint_preserves_draft_when_completion_validation_fails(): void
    {
        [, , $token] = $this->companyAccount('training-submit-invalid@example.com', 'Incomplete Training');
        $created = $this->withToken($token)
            ->postJson('/api/company/trainings', ['title' => 'Draft Only', 'category_role' => 'security'])
            ->assertCreated();
        $uuid = $created->json('data.training.uuid');

        $this->withToken($token)
            ->postJson("/api/company/trainings/{$uuid}/submit")
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'category',
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
            'category_role' => 'security',
            'is_certificate' => true,
            'tags' => ['K3', 'Patroli'],
            'description' => 'Pelatihan dasar untuk calon petugas keamanan.',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-03',
            'total_jp' => 24,
            'training_mode' => 'online',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'BALIKPAPAN',
            'address' => 'Platform pembelajaran Company Aman',
            'syllabus' => ['Pengenalan keamanan', 'Teknik patroli'],
            'requirements' => ['Memiliki KTP', 'Sehat jasmani'],
            'instructor' => 'Budi Santoso',
            'quota' => 20,
            'price' => 0,
            'poster' => null,
            'workflow_action' => 'save_draft',
        ], $overrides);
    }

    /** @return array{0: User, 1: Company, 2: string} */
    private function companyAccount(string $email, string $name): array
    {
        $user = User::create([
            'name' => $name.' User',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $userCompany = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create([
            'user_company_id' => $userCompany->getKey(),
            'company_name' => $name,
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        return [$user, $company, $token];
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
