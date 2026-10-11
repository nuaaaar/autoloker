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

    public function test_admin_publishing_vacancy_stores_history_and_queues_push_for_company_owner(): void
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
        $master = MasterNotification::create([
            'code' => 'job_vacancy_published',
            'name' => 'Lowongan Disetujui',
            'category' => 'lowongan',
            'title_template' => 'Lowongan :position disetujui',
            'message_template' => 'Lowongan :position telah disetujui dan dipublikasikan.',
            'push_enabled' => true,
            'is_active' => true,
        ]);
        $vacancy = JobVacancy::create([
            'company_id' => $company->id,
            'position' => 'Security Officer',
            'status' => 'submitted',
            'working_type' => 'contract',
            'working_system' => 'shift',
        ]);

        $this->actingAs($admin)
            ->postJson("/dashboard-admin/job-vacancy/{$vacancy->uuid}/publish")
            ->assertOk()
            ->assertJsonPath('status', true);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $owner->id,
            'notification_id' => $master->id,
            'title' => 'Lowongan Security Officer disetujui',
        ]);
        Queue::assertPushed(SendFcmNotification::class);
    }
}
