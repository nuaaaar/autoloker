<?php

namespace Tests\Feature\Admin;

use App\Jobs\SendFcmNotification;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\MasterNotification;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PublishNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_publish_a_vacancy_without_an_owner_charge(): void
    {
        Queue::fake();
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'publish-admin@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ]);
        $owner = User::create([
            'name' => 'Company Owner',
            'email' => 'publish-owner@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'company',
            'status' => 'active',
        ]);
        $userCompany = UserCompany::create(['user_id' => $owner->id]);
        $company = Company::create([
            'user_company_id' => $userCompany->id,
            'company_name' => 'Example Company',
        ]);
        $vacancy = JobVacancy::create([
            'company_id' => $company->id,
            'position' => 'Security Officer',
            'status' => 'draft',
            'working_type' => 'contract',
            'working_system' => 'shift',
        ]);

        $this->actingAs($admin)
            ->postJson("/dashboard-admin/job-vacancy/{$vacancy->uuid}/publish")
            ->assertNotFound();

        $this->assertDatabaseHas('job_vacancies', [
            'id' => $vacancy->id,
            'status' => 'draft',
        ]);
    }
}
