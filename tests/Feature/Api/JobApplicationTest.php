<?php

namespace Tests\Feature\Api;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Security;
use App\Models\User;
use App\Models\UserSecurity;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_can_apply_once_to_an_available_vacancy(): void
    {
        [$user, $security] = $this->securityAccount('applicant@example.com');
        $vacancy = JobVacancy::create($this->vacancyAttributes(['kuota' => 1]));
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$vacancy->uuid}/apply")
            ->assertCreated()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.job_application.status', 'applied')
            ->assertJsonPath('data.job_application.job_vacancy_id', $vacancy->id);

        $this->assertDatabaseHas('job_applications', [
            'security_id' => $security->id,
            'job_vacancy_id' => $vacancy->id,
            'status' => 'applied',
        ]);

        $this->withToken($token)
            ->postJson("/api/job-vacancies/{$vacancy->uuid}/apply")
            ->assertUnprocessable()
            ->assertJsonPath('status', false)
            ->assertJsonPath('message', 'You have already applied for this job vacancy.');
    }

    public function test_my_applications_returns_only_authenticated_security_vacancies_with_pagination(): void
    {
        [$user, $security] = $this->securityAccount('my-applications@example.com');
        [, $otherSecurity] = $this->securityAccount('other-applications@example.com');

        foreach (range(1, 6) as $number) {
            $vacancy = JobVacancy::create($this->vacancyAttributes([
                'position' => "Security {$number}",
            ]));

            JobApplication::create([
                'security_id' => $security->id,
                'job_vacancy_id' => $vacancy->id,
                'status' => $number === 6 ? 'reviewed' : 'applied',
            ]);
        }

        $otherVacancy = JobVacancy::create($this->vacancyAttributes([
            'position' => 'Other Security',
        ]));
        JobApplication::create([
            'security_id' => $otherSecurity->id,
            'job_vacancy_id' => $otherVacancy->id,
        ]);

        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->getJson('/api/job-applications')
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.pagination.current_page', 1)
            ->assertJsonPath('data.pagination.per_page', 5)
            ->assertJsonPath('data.pagination.total', 6)
            ->assertJsonPath('data.pagination.has_more', true)
            ->assertJsonCount(5, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 6')
            ->assertJsonPath('data.job_vacancies.0.application_status', 'reviewed')
            ->assertJsonMissing(['position' => 'Other Security']);

        $this->withToken($token)
            ->getJson('/api/job-applications?page=2')
            ->assertOk()
            ->assertJsonPath('data.pagination.current_page', 2)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 1');
    }

    public function test_security_can_cancel_only_its_own_job_application(): void
    {
        [$user, $security] = $this->securityAccount('cancel-job-applicant@example.com');
        [$otherUser] = $this->securityAccount('other-cancel-job-applicant@example.com');
        $vacancy = JobVacancy::create($this->vacancyAttributes());
        $application = JobApplication::create([
            'security_id' => $security->id,
            'job_vacancy_id' => $vacancy->id,
            'status' => 'reviewed',
        ]);
        $applicationUuid = $application->uuid;

        $otherToken = app(TokenService::class)->issue($otherUser)['access_token'];
        $this->withToken($otherToken)
            ->deleteJson("/api/job-applications/{$applicationUuid}")
            ->assertNotFound();
        $this->assertDatabaseHas('job_applications', ['id' => $application->id]);

        $token = app(TokenService::class)->issue($user)['access_token'];
        $this->withToken($token)
            ->deleteJson("/api/job-applications/{$applicationUuid}")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Job application cancelled successfully.');

        $this->assertDatabaseMissing('job_applications', ['id' => $application->id]);
    }

    /** @return array{0: User, 1: Security} */
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
            'name' => 'API Security',
        ]);

        return [$user, $security];
    }

    private function vacancyAttributes(array $overrides = []): array
    {
        return array_merge([
            'position' => 'Security Officer',
            'status' => 'published',
            'end_date' => now()->addDays(7)->toDateString(),
            'province' => 'Jawa Barat',
            'working_type' => 'contract',
            'working_system' => 'shift',
        ], $overrides);
    }
}
