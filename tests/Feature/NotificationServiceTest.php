<?php

namespace Tests\Feature;

use App\Jobs\SendFcmNotification;
use App\Models\MasterNotification;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_interpolates_master_templates_and_queues_push_when_enabled(): void
    {
        Queue::fake();
        $user = $this->user();
        $master = $this->master([
            'title_template' => 'Lamaran baru untuk :position',
            'message_template' => ':applicant melamar :position.',
            'category' => 'lowongan',
            'push_enabled' => true,
            'flutter_route' => 'job/:position',
        ]);

        $notification = app(NotificationService::class)->send($user->id, $master->code, [
            'position' => 'Security Officer',
            'applicant' => 'Dewi',
        ]);

        $this->assertNotNull($notification);
        $this->assertSame('Lamaran baru untuk Security Officer', $notification->title);
        $this->assertSame('Dewi melamar Security Officer.', $notification->description);
        $this->assertSame('lowongan', $notification->type);
        $this->assertSame('job/Security Officer', $notification->url);
        $this->assertFalse($notification->is_read);
        $this->assertSame($master->id, $notification->notification_id);
        Queue::assertPushed(SendFcmNotification::class, fn ($job) => $job->notificationId === $notification->id);
    }

    public function test_send_interpolates_encoded_destination_uuid_into_mobile_route(): void
    {
        Queue::fake();
        $user = $this->user();
        $master = $this->master([
            'flutter_route' => 'autoloker://job-vacancies/:vacancy_uuid',
        ]);

        $notification = app(NotificationService::class)->send($user->id, $master->code, [
            'vacancy_uuid' => rawurlencode('123e4567-e89b-12d3-a456-426614174000'),
        ]);

        $this->assertSame('autoloker://job-vacancies/123e4567-e89b-12d3-a456-426614174000', $notification->url);
    }

    public function test_dashboard_route_is_used_when_flutter_route_is_empty(): void
    {
        Queue::fake();
        $user = $this->user();
        $master = $this->master([
            'flutter_route' => '',
            'dashboard_route' => 'dashboard/jobs/:id',
        ]);

        $notification = app(NotificationService::class)->send($user->id, $master->code, ['id' => 42]);

        $this->assertNotNull($notification);
        $this->assertSame('dashboard/jobs/42', $notification->url);
    }

    public function test_send_stores_history_without_queueing_when_push_is_disabled(): void
    {
        Queue::fake();
        $user = $this->user();
        $master = $this->master(['push_enabled' => false]);

        $notification = app(NotificationService::class)->send($user->id, $master->code);

        $this->assertNotNull($notification);
        $this->assertDatabaseHas('notifications', ['id' => $notification->id, 'user_id' => $user->id]);
        Queue::assertNothingPushed();
    }

    public function test_missing_or_inactive_master_returns_null_without_creating_history(): void
    {
        Queue::fake();
        $user = $this->user();
        $inactive = $this->master(['is_active' => false]);

        $this->assertNull(app(NotificationService::class)->send($user->id, 'missing-code'));
        $this->assertNull(app(NotificationService::class)->send($user->id, $inactive->code));
        $this->assertSame(0, Notification::count());
        Queue::assertNothingPushed();
    }

    private function user(): User
    {
        return User::create([
            'name' => 'Notification User',
            'email' => 'notification-user@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
    }

    private function master(array $overrides = []): MasterNotification
    {
        return MasterNotification::create(array_merge([
            'code' => 'test-notification',
            'name' => 'Test Notification',
            'category' => 'akun',
            'title_template' => 'Title',
            'message_template' => 'Body',
            'push_enabled' => true,
            'is_active' => true,
        ], $overrides));
    }
}
