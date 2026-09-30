<?php

namespace Tests\Feature\Api;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\MasterSubscription;
use App\Models\Training;
use App\Models\User;
use App\Models\UserBUJP;
use App\Models\UserCompany;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSubscriptionLimitUsageTest extends TestCase
{
    use RefreshDatabase;

    public function test_bujp_usage_counts_its_submitted_and_published_job_and_training_posts(): void
    {
        $this->defaultPlan('bujp');
        [$bujp, $token] = $this->bujpAccount('bujp@example.com', 'Aman BUJP');
        [$otherBujp] = $this->bujpAccount('other-bujp@example.com', 'Other BUJP');

        foreach (['submitted', 'published', 'draft', 'rejected', 'closed'] as $status) {
            JobVacancy::create([
                'b_u_j_p_id' => $bujp->getKey(),
                'status' => $status,
            ]);
            Training::create([
                'b_u_j_p_id' => $bujp->getKey(),
                'status' => $status,
            ]);
        }

        JobVacancy::create([
            'b_u_j_p_id' => $otherBujp->getKey(),
            'status' => 'published',
        ]);
        Training::create([
            'b_u_j_p_id' => $otherBujp->getKey(),
            'status' => 'published',
        ]);

        $this->withToken($token)
            ->getJson('/api/user-subscriptions/active')
            ->assertOk()
            ->assertJsonPath('data.user_subscription.role', 'bujp')
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_job_applications', 0)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_training_applications', 0)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_job_posts', 2)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_training_posts', 2);
    }

    public function test_company_usage_counts_its_submitted_and_published_job_posts_only(): void
    {
        $this->defaultPlan('client');
        [$company, $token] = $this->companyAccount('company@example.com', 'Aman Company');
        [$otherCompany] = $this->companyAccount('other-company@example.com', 'Other Company');

        foreach (['submitted', 'published', 'draft', 'rejected', 'closed'] as $status) {
            JobVacancy::create([
                'company_id' => $company->getKey(),
                'status' => $status,
            ]);
        }

        JobVacancy::create([
            'company_id' => $otherCompany->getKey(),
            'status' => 'published',
        ]);
        Training::create([
            'company_id' => $company->getKey(),
            'status' => 'published',
        ]);

        $this->withToken($token)
            ->getJson('/api/user-subscriptions/active')
            ->assertOk()
            ->assertJsonPath('data.user_subscription.role', 'client')
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_job_applications', 0)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_training_applications', 0)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_job_posts', 2)
            ->assertJsonPath('data.user_subscription.limit_usage.total_active_training_posts', 0);
    }

    private function defaultPlan(string $role): void
    {
        MasterSubscription::create([
            'name' => 'Free '.ucfirst($role),
            'slug' => 'free-'.$role,
            'role' => $role,
            'price' => 0,
            'duration' => 30,
            'duration_type' => 'day',
            'features' => [],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    /** @return array{0: BUJP, 1: string} */
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
        $userBujp = UserBUJP::create(['user_id' => $user->getKey()]);
        $bujp = BUJP::create([
            'user_b_u_j_p_id' => $userBujp->getKey(),
            'company_name' => $name,
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        return [$bujp, $token];
    }

    /** @return array{0: Company, 1: string} */
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
        $userCompany = UserCompany::create(['user_id' => $user->getKey()]);
        $company = Company::create([
            'user_company_id' => $userCompany->getKey(),
            'company_name' => $name,
        ]);
        $token = app(TokenService::class)->issue($user)['access_token'];

        return [$company, $token];
    }
}
