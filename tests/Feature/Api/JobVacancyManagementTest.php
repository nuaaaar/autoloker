<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
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
        [$user, $company, $token] = $this->companyAccount('create@example.com', 'Create Company');

        $response = $this->withToken($token)->postJson('/api/company/job-vacancies', $this->payload());

        $response->assertCreated()
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonPath('status', true)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'job_vacancy' => [
                        'uuid',
                        'position',
                        'status',
                        'company' => ['uuid', 'name'],
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
            ->assertJsonPath('data.job_vacancy.company.uuid', (string) $company->uuid)
            ->assertJsonPath('data.job_vacancy.company.name', 'Create Company')
            ->assertJsonPath('data.job_vacancy.province', 'KALIMANTAN TIMUR')
            ->assertJsonPath('data.job_vacancy.city', 'BALIKPAPAN');

        $uuid = $response->json('data.job_vacancy.uuid');
        $response->assertHeader('Location', route('api.company.job-vacancies.show', ['uuid' => $uuid]));

        $this->assertDatabaseHas('job_vacancies', [
            'uuid' => $uuid,
            'company_id' => $company->id,
            'b_u_j_p_id' => null,
            'status' => 'draft',
        ]);

    }

    public function test_patch_updates_only_submitted_fields_and_replaces_arrays(): void
    {
        [, $company, $token] = $this->companyAccount('patch@example.com', 'Patch Company');
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
            ->assertJsonPath('data.job_vacancy.company.uuid', (string) $company->uuid);

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
        [, , $token] = $this->companyAccount('validation@example.com', 'Validation Company');

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
        [, , $ownerToken] = $this->companyAccount('owner@example.com', 'Owner Company');
        [, , $otherToken] = $this->companyAccount('other@example.com', 'Other Company');

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
        [, , $token] = $this->companyAccount('submit-create@example.com', 'Submit Create Company');

        $this->withToken($token)
            ->postJson('/api/company/job-vacancies', $this->payload(['workflow_action' => 'submit']))
            ->assertCreated()
            ->assertJsonPath('data.job_vacancy.status', 'submitted');

        $this->assertDatabaseHas('job_vacancies', ['status' => 'submitted']);
    }

    public function test_submit_rejects_incomplete_draft_without_changing_status(): void
    {
        [, , $token] = $this->companyAccount('submit-invalid@example.com', 'Submit Invalid Company');
        $created = $this->withToken($token)->postJson('/api/company/job-vacancies', [
            'position' => 'Satpam Pabrik',
            'category' => 'security',
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
        [, , $token] = $this->companyAccount('submit@example.com', 'Submit Company');
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
        [, , $token] = $this->companyAccount('immutable@example.com', 'Immutable Company');
        $created = $this->withToken($token)->postJson('/api/company/job-vacancies', $this->payload())
            ->assertCreated();
        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/job-vacancies/{$uuid}", [
                'uuid' => 'forged-uuid',
                'company_id' => 999999,
                'status' => 'submitted',
                'created_at' => '2026-01-01 00:00:00',
                'total_clicked' => 999,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'uuid',
                'company_id',
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

    public function test_worker_and_bujp_roles_cannot_use_vacancy_management_endpoints(): void
    {
        foreach (['satpam', 'cs', 'bujp'] as $role) {
            $user = User::create([
                'name' => 'Non Company User',
                'email' => "non-company-{$role}@example.com",
                'google_id' => null,
                'password' => 'password',
                'role' => $role,
                'status' => 'active',
            ]);
            $token = app(TokenService::class)->issue($user)['access_token'];

            $this->withToken($token)
                ->postJson('/api/company/job-vacancies', $this->payload())
                ->assertNotFound();
        }
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'position' => 'Satpam Pabrik',
            'category' => 'security',
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
            'user_company_id' => $userCompany->id,
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
