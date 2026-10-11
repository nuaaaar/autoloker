<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_lists_real_notifications_and_marks_them_read(): void
    {
        $user = $this->user();
        $notification = $this->notification($user, 'Real notification title');

        $this->actingAs($user)
            ->get(route('dashboard-user.notification.index'))
            ->assertOk()
            ->assertSee('Real notification title');
        $this->actingAs($user)
            ->post(route('dashboard-user.notification.mark-read', $notification->uuid))
            ->assertRedirect();

        $this->assertDatabaseHas('notifications', ['id' => $notification->id, 'is_read' => true]);
    }

    public function test_dashboard_mark_all_read_is_scoped_to_current_user(): void
    {
        $user = $this->user();
        $other = $this->user('dashboard-other@example.com');
        $notification = $this->notification($user, 'Own item');
        $otherNotification = $this->notification($other, 'Other item');

        $this->actingAs($user)
            ->post(route('dashboard-user.notification.mark-all'))
            ->assertRedirect();

        $this->assertDatabaseHas('notifications', ['id' => $notification->id, 'is_read' => true]);
        $this->assertDatabaseHas('notifications', ['id' => $otherNotification->id, 'is_read' => false]);
    }

    private function user(string $email = 'dashboard-user@example.com'): User
    {
        static $sequence = 0;
        $sequence++;

        return User::create([
            'name' => 'Dashboard User',
            'email' => $sequence === 1 ? $email : str_replace('@', "-{$sequence}@", $email),
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
    }

    private function notification(User $user, string $title): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'description' => 'Stored notification body',
            'type' => 'lowongan',
            'is_read' => false,
        ]);
    }
}
