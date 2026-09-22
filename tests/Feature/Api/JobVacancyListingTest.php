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

class JobVacancyListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_filters_published_non_expired_vacancies_and_paginates_by_five(): void
    {
        $token = $this->token();

        foreach (range(1, 6) as $number) {
            JobVacancy::create($this->vacancyAttributes([
                'position' => "Security {$number}",
            ]));
        }

        JobVacancy::create($this->vacancyAttributes([
            'position' => 'Expired Security',
            'end_date' => now()->subDay()->toDateString(),
        ]));
        JobVacancy::create($this->vacancyAttributes([
            'position' => 'Draft Security',
            'status' => 'draft',
        ]));
        JobVacancy::create($this->vacancyAttributes([
            'position' => 'Other Certificate',
            'certificate' => json_encode(['Gada Madya']),
        ]));

        $filters = http_build_query([
            'province_name' => 'Jawa Barat',
            'working_type' => 'contract',
            'working_system' => 'shift',
            'certificate' => 'Gada Pratama',
            'min_price' => 1000000,
            'is_urgent' => 1,
            'min_experience' => 3,
            'gender' => 'laki-laki',
        ]);

        $response = $this->withToken($token)
            ->getJson("/api/job-vacancies?{$filters}");

        $response
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.pagination.current_page', 1)
            ->assertJsonPath('data.pagination.per_page', 5)
            ->assertJsonPath('data.pagination.total', 6)
            ->assertJsonPath('data.pagination.has_more', true)
            ->assertJsonCount(5, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 6');

        $this->assertSame(
            ['Site security'],
            $response->json('data.job_vacancies.0.responsibility')
        );
        $this->assertSame(
            ['Health insurance'],
            $response->json('data.job_vacancies.0.facility')
        );
        $this->assertSame(
            ['Gada Pratama'],
            $response->json('data.job_vacancies.0.certificate')
        );
        $this->assertSame(
            ['Gada Pratama'],
            $response->json('data.job_vacancies.0.competency_scheme')
        );

        $this->withToken($token)
            ->getJson("/api/job-vacancies?{$filters}&page=2")
            ->assertOk()
            ->assertJsonPath('data.pagination.current_page', 2)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 1');
    }

    public function test_list_includes_total_applications_and_authenticated_security_application_state(): void
    {
        [$user, $security] = $this->securityAccount('vacancy-state@example.com');
        [, $otherSecurity] = $this->securityAccount('other-vacancy-state@example.com');

        $notAppliedVacancy = JobVacancy::create($this->vacancyAttributes([
            'position' => 'Not Applied Security',
        ]));
        JobApplication::create([
            'security_id' => $otherSecurity->id,
            'job_vacancy_id' => $notAppliedVacancy->id,
        ]);

        $appliedVacancy = JobVacancy::create($this->vacancyAttributes([
            'position' => 'Applied Security',
        ]));
        JobApplication::create([
            'security_id' => $security->id,
            'job_vacancy_id' => $appliedVacancy->id,
        ]);
        JobApplication::create([
            'security_id' => $otherSecurity->id,
            'job_vacancy_id' => $appliedVacancy->id,
        ]);

        $token = app(TokenService::class)->issue($user)['access_token'];

        $response = $this->withToken($token)
            ->getJson('/api/job-vacancies');

        $response
            ->assertOk()
            ->assertJsonPath('data.job_vacancies.0.position', 'Applied Security')
            ->assertJsonPath('data.job_vacancies.0.total_applications', 2)
            ->assertJsonPath('data.job_vacancies.0.is_appled', true)
            ->assertJsonPath('data.job_vacancies.1.position', 'Not Applied Security')
            ->assertJsonPath('data.job_vacancies.1.total_applications', 1)
            ->assertJsonPath('data.job_vacancies.1.is_appled', false);
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

    private function token(): string
    {
        $user = User::create([
            'name' => 'API User',
            'email' => 'vacancy-list@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);

        return app(TokenService::class)->issue($user)['access_token'];
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
            'responsibility' => json_encode(['Site security']),
            'facility' => json_encode(['Health insurance']),
            'certificate' => json_encode(['Gada Pratama']),
            'competency_scheme' => json_encode(['Gada Pratama']),
            'min_price' => '5000000',
            'is_urgent' => true,
            'min_experience' => '2',
            'gender' => 'laki-laki',
        ], $overrides);
    }
}
