<?php

namespace Tests\Feature\Api;

use App\Models\BUJP;
use App\Models\Company;
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

        $nextPage = $response->json('data.pagination.next_page_url');
        $this->assertStringContainsString('province_name=Jawa%20Barat', $nextPage);
        $this->withToken($token)
            ->getJson($nextPage)
            ->assertOk()
            ->assertJsonPath('data.pagination.current_page', 2)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 1');
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

    }

    public function test_list_includes_company_and_bujp_logo_urls(): void
    {
        config(['filesystems.disks.public.url' => 'https://assets.example.test/storage']);
        $token = $this->token();

        $company = Company::create(['company_name' => 'Logo Company', 'logo' => 'company-logo/company.png']);
        $bujp = BUJP::create(['company_name' => 'Logo BUJP', 'logo' => 'company-logo/bujp.png']);
        $vacancies = [
            JobVacancy::create($this->vacancyAttributes([
                'position' => 'Company Logo', 'company_id' => $company->id, 'category' => 'security',
            ])),
            JobVacancy::create($this->vacancyAttributes([
                'position' => 'BUJP Logo', 'b_u_j_p_id' => $bujp->id, 'category' => 'security',
            ])),
            JobVacancy::create($this->vacancyAttributes([
                'position' => 'No Logo', 'company_id' => Company::create([
                    'company_name' => 'No Logo Company', 'logo' => null,
                ])->id, 'category' => 'security',
            ])),
            JobVacancy::create($this->vacancyAttributes([
                'position' => 'Empty Logo', 'company_id' => Company::create([
                    'company_name' => 'Empty Logo Company', 'logo' => '',
                ])->id, 'category' => 'security',
            ])),
            JobVacancy::create($this->vacancyAttributes(['position' => 'No Owner', 'category' => 'security'])),
            JobVacancy::create($this->vacancyAttributes([
                'position' => 'Both Owners', 'company_id' => $company->id, 'b_u_j_p_id' => $bujp->id, 'category' => 'security',
            ])),
        ];

        $response = $this->withToken($token)->getJson('/api/job-vacancies');
        $response->assertOk();
        $secondPage = $this->withToken($token)->getJson('/api/job-vacancies?page=2');
        $secondPage->assertOk();
        $items = collect(array_merge($response->json('data.job_vacancies'), $secondPage->json('data.job_vacancies')))->keyBy('position');
        $this->assertSame('https://assets.example.test/storage/company-logo/company.png', $items['Company Logo']['company']['logo']);
        $this->assertSame('https://assets.example.test/storage/company-logo/bujp.png', $items['BUJP Logo']['bujp']['logo']);
        $this->assertArrayHasKey('logo', $items['No Logo']['company']);
        $this->assertNull($items['No Logo']['company']['logo']);
        $this->assertNull($items['Empty Logo']['company']['logo']);
        $this->assertNull($items['No Owner']['company']);
        $this->assertNull($items['No Owner']['bujp']);
        $this->assertSame('https://assets.example.test/storage/company-logo/company.png', $items['Both Owners']['company']['logo']);
        $this->assertSame('https://assets.example.test/storage/company-logo/bujp.png', $items['Both Owners']['bujp']['logo']);
        $this->assertCount(6, $vacancies);
    }

    public function test_empty_search_results_keep_pagination_shape(): void
    {
        $this->withToken($this->token())
            ->getJson('/api/job-vacancies?search=No%20matching%20vacancy')
            ->assertOk()
            ->assertJsonCount(0, 'data.job_vacancies')
            ->assertJsonPath('data.pagination.total', 0)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonPath('data.pagination.next_page_url', null);
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

    public function test_applicant_can_read_only_its_applied_vacancy_detail(): void
    {
        [$user, $security] = $this->securityAccount('vacancy-detail@example.com');
        $vacancy = JobVacancy::create($this->vacancyAttributes());
        JobApplication::create(['security_id' => $security->id, 'job_vacancy_id' => $vacancy->id, 'status' => 'pending']);
        $token = app(TokenService::class)->issue($user)['access_token'];

        $this->withToken($token)
            ->getJson("/api/job-vacancies/{$vacancy->uuid}")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.job_vacancy.uuid', (string) $vacancy->uuid)
            ->assertJsonPath('data.job_vacancy.is_applied', true)
            ->assertJsonPath('data.job_vacancy.application_status', 'pending');

        $otherToken = app(TokenService::class)->issue($this->securityAccount('unrelated-vacancy@example.com')[0])['access_token'];
        $this->withToken($otherToken)
            ->getJson("/api/job-vacancies/{$vacancy->uuid}")
            ->assertNotFound()
            ->assertJsonPath('status', false)
            ->assertJsonMissingPath('data.job_vacancy');
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
        $userSecurity = UserSecurity::create(['user_id' => $user->id]);
        Security::create([
            'user_security_id' => $userSecurity->id,
            'name' => 'API User',
        ]);

        return app(TokenService::class)->issue($user)['access_token'];
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
