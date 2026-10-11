<?php

namespace Tests\Feature;

use App\Models\MasterNotification;
use Database\Seeders\MasterNotificationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterNotificationSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_all_thirteen_push_enabled_templates_idempotently(): void
    {
        $seeder = app(MasterNotificationSeeder::class);

        $seeder->run();
        $expectedRoutes = [
            'job_application_created' => 'autoloker://company/job-vacancies/:vacancy_uuid',
            'job_application_status_changed' => 'autoloker://job-vacancies/:vacancy_uuid',
            'training_application_created' => 'autoloker://company/trainings/:training_uuid',
            'training_application_status_changed' => 'autoloker://trainings/:training_uuid',
            'job_vacancy_published' => 'autoloker://company/job-vacancies/:vacancy_uuid',
            'job_vacancy_rejected' => 'autoloker://company/job-vacancies/:vacancy_uuid',
            'training_published' => 'autoloker://company/trainings/:training_uuid',
            'training_rejected' => 'autoloker://company/trainings/:training_uuid',
            'order_subscription_approved' => 'autoloker://subscription-orders/:order_uuid',
            'order_subscription_rejected' => 'autoloker://subscription-orders/:order_uuid',
            'company_verified' => 'autoloker://notifications',
            'company_status_changed' => 'autoloker://notifications',
            'security_status_changed' => 'autoloker://notifications',
        ];
        ksort($expectedRoutes);
        $this->assertSame($expectedRoutes, MasterNotification::query()->orderBy('code')->pluck('flutter_route', 'code')->all());

        $ids = MasterNotification::query()->pluck('id', 'code')->all();
        $seeder->run();

        $this->assertSame(13, MasterNotification::count());
        $this->assertSame(13, MasterNotification::where('push_enabled', true)->count());
        $this->assertSame(13, MasterNotification::where('is_active', true)->count());
        $this->assertSame($ids, MasterNotification::query()->pluck('id', 'code')->all());
        $this->assertSame($expectedRoutes, MasterNotification::query()->orderBy('code')->pluck('flutter_route', 'code')->all());
        $this->assertDatabaseHas('master_notifications', [
            'code' => 'training_application_status_changed',
            'title_template' => 'Status pendaftaran :training',
        ]);
    }
}
