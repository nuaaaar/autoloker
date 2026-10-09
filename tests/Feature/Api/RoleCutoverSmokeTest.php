<?php

namespace Tests\Feature\Api;

use App\Models\CleaningService;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\MasterAbility;
use App\Models\MasterCategoryCertificate;
use App\Models\MasterSubscription;
use App\Models\Security;
use App\Models\Training;
use App\Models\User;
use App\Models\UserCleaningService;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * End-to-end cutover smoke scenario: a worker fills a security profile, switches
 * to cleaning service without losing security data, works the cs feed with the
 * cleaning_service_id foreign key, and switches back to find everything intact.
 */
class RoleCutoverSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedLocations();
    }

    public function test_worker_switches_role_without_losing_profiles_applications_or_quota_usage(): void
    {
        MasterSubscription::create([
            'name' => 'Free Security',
            'slug' => 'free-security',
            'role' => 'security',
            'price' => 0,
            'duration' => 30,
            'duration_type' => 'day',
            'features' => [],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Storage::fake('public');
        MasterAbility::create(['title' => 'Menjaga kebersihan area', 'category' => 'cs']);
        [$user, $security] = $this->completeSecurityAccount('cutover@example.com');
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('data.profile.type', 'security')
            ->assertJsonPath('data.profile.profile_completion.total', 21)
            ->assertJsonPath('data.profile.profile_completion.completed', 21);


        // Login accepts the cs role only once a cs profile exists.
        $csVacancy = JobVacancy::create($this->vacancyAttributes(['category' => 'cs', 'position' => 'Cleaning Staff']));
        $securityVacancy = JobVacancy::create($this->vacancyAttributes(['category' => 'security', 'position' => 'Satpam Pabrik']));
        $csTraining = Training::create($this->trainingAttributes(['category_role' => 'cs', 'title' => 'Pelatihan CS']));
        $securityTraining = Training::create($this->trainingAttributes(['category_role' => 'security', 'title' => 'Pelatihan Satpam']));

        $this->withToken($token)
            ->getJson('/api/job-vacancies')
            ->assertOk()
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.category', 'security');

        // Security applications work with the security foreign key.
        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$securityVacancy->uuid}/apply")
            ->assertCreated();
        $this->withToken($token)
            ->postJson("/api/trainings/{$securityTraining->uuid}/apply")
            ->assertCreated();

        // Switch to cs: the response carries the GET /me envelope.
        $this->withToken($token)
            ->postJson('/api/profile/change-role', ['role' => 'cs'])
            ->assertOk()
            ->assertJsonPath('data.me.role', 'cs')
            ->assertJsonPath('data.me.profile.type', 'cs')
            ->assertJsonPath('data.me.profile.profile_completion.total', 21);

        $this->assertSame('cs', $user->fresh()->role);
        $this->assertDatabaseHas('securities', ['id' => $security->id, 'name' => 'Cutover Security']);
        $this->assertSame(1, DB::table('job_applications')->where('security_id', $security->id)->count());

        // Feed follows the active role and rejects the other category.
        $this->withToken($token)
            ->getJson('/api/job-vacancies')
            ->assertOk()
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.category', 'cs')
            ->assertJsonPath('data.job_vacancies.0.position', 'Cleaning Staff');

        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$securityVacancy->uuid}/apply")
            ->assertNotFound();

        $this->withToken($token)
            ->getJson('/api/trainings')
            ->assertOk()
            ->assertJsonCount(1, 'data.trainings')
            ->assertJsonPath('data.trainings.0.title', 'Pelatihan CS');

        $this->withToken($token)
            ->postJson("/api/trainings/{$securityTraining->uuid}/apply")
            ->assertNotFound();

        // The freshly created cs profile is empty, so the 21-field gate blocks it.
        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$csVacancy->uuid}/apply")
            ->assertStatus(422)
            ->assertJsonPath('data.total', 21)
            ->assertJsonPath('status', false);

        // Filling the cs profile unlocks applications under the new foreign key.
        $this->withToken($token)
            ->patchJson('/api/profile', $this->completeCsProfilePayload())
            ->assertOk()
            ->assertJsonPath('data.profile.type', 'cs')
            ;

        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$csVacancy->uuid}/apply")
            ->assertCreated();

        $cleaningService = CleaningService::query()->firstOrFail();
        $this->assertDatabaseHas('job_applications', [
            'job_vacancy_id' => $csVacancy->id,
            'cleaning_service_id' => $cleaningService->id,
            'security_id' => null,
        ]);

        $this->withToken($token)
            ->getJson('/api/job-applications')
            ->assertOk()
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Cleaning Staff');

        // Usage is account-wide, so switching role did not reset quota.
        $this->withToken($token)
            ->getJson('/api/user-subscriptions/active')
            ->assertOk()
            ->assertJsonPath('data.user_subscription.role', 'security')
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_job_applications', 2)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_training_applications', 1);

        // Switch back: security data and applications are still available.
        $this->withToken($token)
            ->postJson('/api/profile/change-role', ['role' => 'security'])
            ->assertOk()
            ->assertJsonPath('data.me.role', 'satpam')
            ->assertJsonPath('data.me.profile.type', 'security');

        $this->withToken($token)
            ->getJson('/api/job-applications')
            ->assertOk()
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Satpam Pabrik');
    }

    public function test_incomplete_worker_profile_is_rejected_with_progress_and_no_application_row(): void
    {
        $user = User::create([
            'name' => 'Incomplete Worker',
            'email' => 'incomplete@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        Security::create([
            'user_security_id' => $relation->id,
            'formal_photo' => 'formal-photo/worker.jpg',
            'name' => 'Incomplete Worker',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-01-01',
            'gender' => 'laki-laki',
            'address' => 'Jl. Merdeka 1',
            'phone_number' => '081234567890',
            'email' => 'incomplete@example.com',
            'ktp_number' => '3273010101950001',
            'registration_number' => 'REG-002',
            'work_experience' => '1 tahun',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'village' => 'Dago',
            'height' => '170',
            'width' => '65',
            'is_out_of_town_agree' => true,
            'is_shift_agree' => true,
            'ability' => 'Patroli',
            // work_status intentionally missing: 20 of 21 fields.
        ]);
        $vacancy = JobVacancy::create($this->vacancyAttributes(['category' => 'security']));
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$vacancy->uuid}/apply")
            ->assertStatus(422)
            ->assertJsonPath('status', false)
            ->assertJsonPath('data.completed', 20)
            ->assertJsonPath('data.total', 21)
            ->assertJsonPath('data.progress', 95)
            ->assertJsonPath('data.missing', ['Status Satpam']);

        $this->assertSame(0, DB::table('job_applications')->count());
    }

    public function test_company_master_data_and_category_locking(): void
    {
        [$company, $token] = $this->companyAccount('cutover-company@example.com');

        $this->withToken($token)
            ->getJson('/api/company/job-vacancies/master-data?category=cs')
            ->assertOk()
            ->assertJsonPath('data.category', 'cs')
            ->assertJsonStructure(['data' => ['positions', 'certificates', 'competency_schemes']]);

        $this->withToken($token)
            ->getJson('/api/company/job-vacancies/master-data?category=invalid')
            ->assertStatus(422);

        $created = $this->withToken($token)
            ->postJson('/api/company/job-vacancies', [
                'position' => 'Cleaner Gedung',
                'category' => 'cs',
            ])
            ->assertCreated()
            ->assertJsonPath('data.job_vacancy.category', 'cs');

        $uuid = $created->json('data.job_vacancy.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/job-vacancies/{$uuid}", ['category' => 'security'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('category');

        $this->assertDatabaseHas('job_vacancies', ['uuid' => $uuid, 'category' => 'cs', 'company_id' => $company->id]);
    }

    public function test_company_manages_trainings_and_bujp_cannot_use_publisher_endpoints(): void
    {
        [, $token] = $this->companyAccount('cutover-training-company@example.com');

        $created = $this->withToken($token)
            ->postJson('/api/company/trainings', [
                'title' => 'Pelatihan CS Gedung',
                'category_role' => 'cs',
            ])
            ->assertCreated()
            ->assertJsonPath('data.training.category_role', 'cs')
            ->assertJsonPath('data.training.bujp', null);

        $uuid = $created->json('data.training.uuid');

        $this->withToken($token)
            ->patchJson("/api/company/trainings/{$uuid}", ['category_role' => 'security'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('category_role');

        $bujpUser = User::create([
            'name' => 'Legacy BUJP',
            'email' => 'legacy-bujp@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'bujp',
            'status' => 'active',
        ]);
        $bujpToken = app(TokenService::class)->issue($bujpUser)['access_token'];

        $this->withToken($bujpToken)
            ->getJson('/api/company/trainings')
            ->assertNotFound();
        $this->withToken($bujpToken)
            ->getJson('/api/company/job-vacancies')
            ->assertNotFound();
        $this->withToken($bujpToken)
            ->getJson('/api/company/job-vacancies/master-data?category=security')
            ->assertNotFound();
    }

    public function test_cs_certificate_and_history_crud_are_role_scoped(): void
    {
        MasterCategoryCertificate::create(['title' => 'Teknis Operasional']);
        [$user] = $this->csAccount('cs-crud@example.com');
        $token = app(TokenService::class)->issue($user)['access_token'];

        $created = $this->withToken($token)
            ->postJson('/api/cleaning-service-certificates', [
                'title' => 'Sertifikat CS',
                'publisher' => 'BNSP',
                'certificate_number' => 'CS-001',
                'category' => 'Teknis Operasional',
                'publish_date' => '2026-09-18',
                'expired_date' => '2030-12-18',
                'is_badge' => 1,
            ])
            ->assertCreated()
            ->assertJsonPath('data.cleaning_service_certificate.title', 'Sertifikat CS');

        $uuid = $created->json('data.cleaning_service_certificate.uuid');

        $this->withToken($token)
            ->getJson('/api/cleaning-service-certificates')
            ->assertOk()
            ->assertJsonCount(1, 'data.cleaning_service_certificates');

        $this->withToken($token)
            ->deleteJson("/api/cleaning-service-certificates/{$uuid}")
            ->assertOk();

        $history = $this->withToken($token)
            ->postJson('/api/cleaning-service-histories', [
                'position' => 'Cleaning Service',
                'company_name' => 'PT Bersih',
                'start_date' => '2025-01-01',
                'is_current' => true,
                'end_date' => null,
            ])
            ->assertCreated()
            ->assertJsonPath('data.cleaning_service_history.is_current', true);

        $historyUuid = $history->json('data.cleaning_service_history.uuid');

        $this->withToken($token)
            ->getJson('/api/cleaning-service-histories')
            ->assertOk()
            ->assertJsonCount(1, 'data.cleaning_service_histories');

        // A security account cannot read cs resources.
        $securityUser = User::create([
            'name' => 'Plain Security',
            'email' => 'plain-security@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        UserSecurity::create(['user_id' => $securityUser->id]);
        $securityToken = app(TokenService::class)->issue($securityUser)['access_token'];

        $this->withToken($securityToken)
            ->getJson('/api/cleaning-service-histories')
            ->assertNotFound();
        $this->withToken($securityToken)
            ->getJson("/api/cleaning-service-histories/{$historyUuid}")
            ->assertNotFound();
    }

    /** @return array{0: User, 1: Security} */
    private function completeSecurityAccount(string $email): array
    {
        $user = User::create([
            'name' => 'Cutover Worker',
            'email' => $email,
            'phone_number' => '081234567899',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $relation = UserSecurity::create(['user_id' => $user->id]);
        $security = Security::create([
            'user_security_id' => $relation->id,
            'formal_photo' => 'formal-photo/cutover.jpg',
            'name' => 'Cutover Security',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-01-01',
            'gender' => 'laki-laki',
            'address' => 'Jl. Merdeka 1',
            'phone_number' => '081234567899',
            'email' => $email,
            'ktp_number' => '3273010101950001',
            'registration_number' => 'REG-001',
            'work_experience' => '3 tahun',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'village' => 'Dago',
            'height' => '170',
            'width' => '65',
            'is_out_of_town_agree' => true,
            'is_shift_agree' => true,
            'ability' => 'Patroli',
            'work_status' => 'Siap kerja',
        ]);

        return [$user, $security];
    }

    /** @return array{0: User, 1: CleaningService} */
    private function csAccount(string $email): array
    {
        $user = User::create([
            'name' => 'CS Worker',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'cs',
            'status' => 'active',
        ]);
        $relation = UserCleaningService::create(['user_id' => $user->id]);
        $cleaningService = CleaningService::create([
            'user_cleaning_service_id' => $relation->id,
            'name' => 'CS Worker',
        ]);

        return [$user, $cleaningService];
    }

    /** @return array{0: Company, 1: string} */
    private function companyAccount(string $email): array
    {
        $user = User::create([
            'name' => 'Cutover Company',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $userCompany = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create([
            'user_company_id' => $userCompany->id,
            'company_name' => 'Cutover Company',
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        return [$company, $token];
    }

    /** @return array<string, mixed> */
    private function completeCsProfilePayload(): array
    {
        return [
            'formal_photo' => UploadedFile::fake()->image('cs-photo.jpg'),
            'birth_place' => 'Bandung',
            'birth_date' => '1996-02-02',
            'gender' => 'perempuan',
            'address' => 'Jl. Bersih 2',
            'ktp_number' => '3273010202960002',
            'registration_number' => 'CS-REG-001',
            'work_experience' => '2 tahun',
            'province' => '32',
            'city' => '3273',
            'district' => '327301',
            'village' => '3273011001',
            'height' => '160',
            'width' => '55',
            'is_out_of_town_agree' => true,
            'is_shift_agree' => true,
            'ability' => ['Menjaga kebersihan area'],
            'work_status' => 'Siap kerja',
        ];
    }

    private function vacancyAttributes(array $overrides = []): array
    {
        return array_merge([
            'position' => 'Security Officer',
            'category' => 'security',
            'status' => 'published',
            'end_date' => now()->addDays(7)->toDateString(),
            'province' => 'Jawa Barat',
            'working_type' => 'contract',
            'working_system' => 'shift',
        ], $overrides);
    }

    private function trainingAttributes(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Security Training',
            'provider' => 'Training Provider',
            'category_role' => 'security',
            'status' => 'published',
            'quota' => 10,
            'start_date' => now()->addDays(7)->toDateString(),
        ], $overrides);
    }

    private function seedLocations(): void
    {
        $timestamp = now();

        DB::table('indonesia_provinces')->insert([
            'code' => '32',
            'name' => 'Jawa Barat',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_cities')->insert([
            'code' => '3273',
            'province_code' => '32',
            'name' => 'Bandung',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_districts')->insert([
            'code' => '327301',
            'city_code' => '3273',
            'name' => 'Coblong',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_villages')->insert([
            'code' => '3273011001',
            'district_code' => '327301',
            'name' => 'Dago',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
