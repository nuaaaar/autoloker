<?php

namespace Tests\Feature\Api;

use App\Jobs\SendFcmNotification;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\MasterNotification;
use App\Models\Security;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JobApplicationPushTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_application_creates_owner_history_and_queues_push(): void
    {
        Queue::fake();
        [$applicant, $security] = $this->securityAccount('apply-push@example.com');
        [$owner, $company] = $this->companyAccount('owner-push@example.com');
        $master = $this->master(true);
        $vacancy = JobVacancy::create([
            'company_id' => $company->id,
            'position' => 'Security Officer',
            'category' => 'security',
            'status' => 'published',
            'end_date' => now()->addDays(7)->toDateString(),
            'province' => 'Jawa Barat',
            'working_type' => 'contract',
            'working_system' => 'shift',
        ]);

        $this->withToken(app(TokenService::class)->issue($applicant)['access_token'])
            ->postJson("/api/job-vacancies/{$vacancy->uuid}/apply")
            ->assertCreated()
            ->assertJsonPath('status', true);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $owner->id,
            'notification_id' => $master->id,
            'title' => 'Lamaran baru untuk Security Officer',
            'description' => 'API Security melamar lowongan Security Officer.',
        ]);
        Queue::assertPushed(SendFcmNotification::class);
        $this->assertDatabaseHas('job_applications', [
            'security_id' => $security->id,
            'job_vacancy_id' => $vacancy->id,
        ]);
    }

    public function test_application_history_is_stored_even_when_master_push_is_disabled(): void
    {
        Queue::fake();
        [$applicant] = $this->securityAccount('apply-no-push@example.com');
        [$owner, $company] = $this->companyAccount('owner-no-push@example.com');
        $master = $this->master(false);
        $vacancy = JobVacancy::create([
            'company_id' => $company->id,
            'position' => 'Guard',
            'category' => 'security',
            'status' => 'published',
            'end_date' => now()->addDays(7)->toDateString(),
            'province' => 'Jawa Barat',
            'working_type' => 'contract',
            'working_system' => 'shift',
        ]);

        $this->withToken(app(TokenService::class)->issue($applicant)['access_token'])
            ->postJson("/api/job-vacancies/{$vacancy->uuid}/apply")
            ->assertCreated();

        $this->assertDatabaseHas('notifications', [
            'user_id' => $owner->id,
            'notification_id' => $master->id,
            'title' => 'Lamaran baru untuk Guard',
        ]);
        Queue::assertNothingPushed();
    }

    private function securityAccount(string $email): array
    {
        $user = User::create([
            'name' => 'API Security',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
        $userSecurity = UserSecurity::create(['user_id' => $user->id]);
        $security = Security::create([
            'user_security_id' => $userSecurity->id,
            'formal_photo' => 'formal-photo/api-security.jpg',
            'name' => 'API Security',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-01-01',
            'gender' => 'laki-laki',
            'address' => 'Jl. Merdeka 1',
            'phone_number' => '081234567890',
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

    private function companyAccount(string $email): array
    {
        $user = User::create([
            'name' => 'Company Owner',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $account = UserCompany::create(['user_id' => $user->id]);
        $company = Company::create([
            'user_company_id' => $account->id,
            'company_name' => 'Example Company',
        ]);

        return [$user, $company];
    }

    private function master(bool $pushEnabled): MasterNotification
    {
        return MasterNotification::create([
            'code' => 'job_application_created',
            'name' => 'Lamaran Lowongan Baru',
            'category' => 'lowongan',
            'title_template' => 'Lamaran baru untuk :position',
            'message_template' => ':applicant melamar lowongan :position.',
            'push_enabled' => $pushEnabled,
            'is_active' => true,
        ]);
    }
}
