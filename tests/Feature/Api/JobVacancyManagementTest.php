<?php

namespace Tests\Feature\Api;

use App\Models\BUJP;
use App\Models\User;
use App\Models\UserBUJP;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class JobVacancyManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedLocations();
    }

    public function test_post_creates_draft_with_canonical_envelope_and_location_header(): void
    {
        [$user, $bujp, $token] = $this->bujpAccount('create@example.com', 'Create BUJP');

        $response = $this->withToken($token)->postJson('/api/company/job-vacancies', $this->payload());

        $response->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Job vacancy created successfully.')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'job_vacancy' => [
                        'uuid',
                        'position',
                        'status',
                        'bujp' => ['uuid', 'name'],
                        'province',
                        'city',
                        'address',
                        'working_type',
                        'working_system',
                        'description_work',
                        'responsibilities',
                        'min_age',
                        'max_age',
                        'min_height',
                        'max_height',
                        'min_weight',
                        'max_weight',
                        'last_education',
                        'min_experience',
                        'certificate',
                        'competency_scheme',
                        'facility',
                        'min_price',
                        'max_price',
                        'is_show_fee',
                        'is_urgent',
                        'quota',
                        'end_date',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
            ->assertJsonPath('data.job_vacancy.position', 'Satpam Pabrik')
            ->assertJsonPath('data.job_vacancy.status', 'draft')
            ->assertJsonPath('data.job_vacancy.bujp.uuid', (string) $bujp->uuid)
            ->assertJsonPath('data.job_vacancy.bujp.name', 'Create BUJP')
            ->assertJsonPath('data.job_vacancy.province', 'KALIMANTAN TIMUR')
            ->assertJsonPath('data.job_vacancy.city', 'BALIKPAPAN');

        $uuid = $response->json('data.job_vacancy.uuid');
        $response->assertHeader('Location', route('api.company.job-vacancies.show', ['uuid' => $uuid]));

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'b_u_j_p_id' => $bujp->id,
            'company_id' => null,
            'status' => 'draft',
        ]);

    }

    public function test_patch_updates_only_submitted_fields_and_replaces_arrays(): void
    {
        [, $bujp, $token] = $this->bujpAccount('patch@example.com', 'Patch BUJP');
        $created = $this->withToken($token)->postJson('/api/company/job-vacancies', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/job-vacancies/{$uuid}", [
                'position' => 'Satpam Pabrik Updated',
                'responsibilities' => ['Menjaga gerbang utama'],
                'address' => null,
                'facility' => null,
                'is_urgent' => true,
            ])
            ->assertOk()
            ->assertJsonPath('data.job_vacancy.position', 'Satpam Pabrik Updated')
            ->assertJsonPath('data.job_vacancy.description_work', 'Menjaga keamanan area pabrik.')
            ->assertJsonPath('data.job_vacancy.responsibilities', ['Menjaga gerbang utama'])
            ->assertJsonPath('data.job_vacancy.facility', null)
            ->assertJsonPath('data.job_vacancy.is_urgent', true)
            ->assertJsonPath('data.job_vacancy.status', 'draft')
            ->assertJsonPath('data.job_vacancy.bujp.uuid', (string) $bujp->uuid);

        $this->withToken($token)
            ->getJson("/api/company/job-vacancies/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.job_vacancy.position', 'Satpam Pabrik Updated')
            ->assertJsonPath('data.job_vacancy.status', 'draft');

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'position' => 'Satpam Pabrik Updated',
            'description_work' => 'Menjaga keamanan area pabrik.',
            'address' => null,
            'responsibility' => json_encode(['Menjaga gerbang utama']),
            'facility' => null,
            'status' => 'draft',
        ]);
    }

    public function test_post_returns_per_field_validation_errors(): void
    {
        [, , $token] = $this->bujpAccount('validation@example.com', 'Validation BUJP');

        $response = $this->withToken($token)->postJson('/api/company/job-vacancies', [
            'position' => 'No',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'BANDUNG',
            'working_type' => 'temporary',
            'working_system' => 'office',
            'min_age' => 17,
            'max_age' => 16,
            'min_price' => 5000000,
            'max_price' => 1000000,
            'quota' => 0,
            'end_date' => '20-10-2026',
        ]);

        $response->assertUnprocessable()
            ->assertJsonPath('status', false)
            ->assertJsonValidationErrors([
                'position',
                'city',
                'working_type',
                'working_system',
                'min_age',
                'max_age',
                'min_price',
                'quota',
                'end_date',
            ]);

        $this->assertDatabaseCount('job_vacancies', 0);
    }

    public function test_vacancy_ownership_isolation_returns_not_found(): void
    {
        [, , $ownerToken] = $this->bujpAccount('owner@example.com', 'Owner BUJP');
        [, , $otherToken] = $this->bujpAccount('other@example.com', 'Other BUJP');

        $created = $this->withToken($ownerToken)->postJson('/api/company/job-vacancies', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($otherToken)
            ->getJson("/api/company/job-vacancies/{$uuid}")
            ->assertNotFound();

        $this->withToken($otherToken)
            ->patchJson("/api/company/job-vacancies/{$uuid}", ['position' => 'Hijacked Position'])
            ->assertNotFound();

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'position' => 'Satpam Pabrik',
        ]);
    }

    public function test_post_submit_action_creates_submitted_vacancy(): void
    {
        [, , $token] = $this->bujpAccount('submit-create@example.com', 'Submit Create BUJP');

        $this->withToken($token)
            ->postJson('/api/company/job-vacancies', $this->payload(['workflow_action' => 'submit']))
            ->assertCreated()
            ->assertJsonPath('data.job_vacancy.status', 'submitted');

        $this->assertDatabaseHas('job_vacancies', ['status' => 'submitted']);
    }

    public function test_submit_rejects_incomplete_draft_without_changing_status(): void
    {
        [, , $token] = $this->bujpAccount('submit-invalid@example.com', 'Submit Invalid BUJP');
        $created = $this->withToken($token)->postJson('/api/company/job-vacancies', [
            'position' => 'Satpam Pabrik',
            'workflow_action' => 'save_draft',
        ])->assertCreated();
        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($token)
            ->postJson("/api/company/job-vacancies/{$uuid}/submit")
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'description_work',
                'province',
                'city',
                'responsibilities',
                'min_age',
                'certificate',
                'quota',
                'end_date',
            ]);

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'status' => 'draft',
        ]);
    }

    public function test_submit_changes_owned_complete_draft_to_submitted(): void
    {
        [, , $token] = $this->bujpAccount('submit@example.com', 'Submit BUJP');
        $created = $this->withToken($token)->postJson('/api/company/job-vacancies', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($token)
            ->postJson("/api/company/job-vacancies/{$uuid}/submit")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.job_vacancy.status', 'submitted');

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'status' => 'submitted',
        ]);
    }

    public function test_patch_rejects_immutable_owner_status_timestamp_and_counter_fields(): void
    {
        [, , $token] = $this->bujpAccount('immutable@example.com', 'Immutable BUJP');
        $created = $this->withToken($token)->postJson('/api/company/job-vacancies', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/job-vacancies/{$uuid}", [
                'uuid' => 'forged-uuid',
                'b_u_j_p_id' => 999999,
                'status' => 'submitted',
                'created_at' => '2026-01-01 00:00:00',
                'total_clicked' => 999,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'uuid',
                'b_u_j_p_id',
                'status',
                'created_at',
                'total_clicked',
            ]);

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'status' => 'draft',
            'total_clicked' => null,
        ]);
    }

    public function test_non_bujp_role_cannot_use_vacancy_management_endpoints(): void
    {
        $user = User::create([
            'name' => 'Security User',
            'email' => 'security-vacancy@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson('/api/company/job-vacancies', $this->payload())
            ->assertNotFound();
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'position' => 'Satpam Pabrik',
            'description_work' => 'Menjaga keamanan area pabrik.',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'BALIKPAPAN',
            'address' => 'Kawasan Industri Bandung',
            'working_type' => 'permanent',
            'working_system' => 'shift',
            'responsibilities' => ['Menjaga akses masuk dan keluar'],
            'min_age' => 21,
            'max_age' => 35,
            'min_height' => 165,
            'max_height' => 190,
            'min_weight' => 50,
            'max_weight' => 90,
            'last_education' => 'D3',
            'min_experience' => 1,
            'certificate' => ['Gada Pratama'],
            'competency_scheme' => ['Patroli'],
            'facility' => ['Transportasi'],
            'min_price' => 3500000,
            'max_price' => 5000000,
            'is_show_fee' => true,
            'is_urgent' => false,
            'quota' => 4,
            'end_date' => '2026-10-20',
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
