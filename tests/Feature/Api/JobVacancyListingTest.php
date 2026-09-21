<?php

namespace Tests\Feature\Api;

use App\Models\JobVacancy;
use App\Models\User;
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

        $this->withToken($token)
            ->getJson("/api/job-vacancies?{$filters}")
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.pagination.current_page', 1)
            ->assertJsonPath('data.pagination.per_page', 5)
            ->assertJsonPath('data.pagination.total', 6)
            ->assertJsonPath('data.pagination.has_more', true)
            ->assertJsonCount(5, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 6');

        $this->withToken($token)
            ->getJson("/api/job-vacancies?{$filters}&page=2")
            ->assertOk()
            ->assertJsonPath('data.pagination.current_page', 2)
            ->assertJsonPath('data.pagination.has_more', false)
            ->assertJsonCount(1, 'data.job_vacancies')
            ->assertJsonPath('data.job_vacancies.0.position', 'Security 1');
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
            'certificate' => json_encode(['Gada Pratama']),
            'min_price' => '5000000',
            'is_urgent' => true,
            'min_experience' => '2',
            'gender' => 'laki-laki',
        ], $overrides);
    }
}
