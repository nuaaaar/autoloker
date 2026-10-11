<?php

namespace Tests\Feature\Api;

use App\Models\Notification;
use App\Models\User;
use App\Services\Api\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_returns_only_the_authenticated_users_rows_newest_first(): void
    {
        $user = $this->user('history@example.com');
        $other = $this->user('other-history@example.com');
        $older = $this->notification($user, ['title' => 'Older']);
        $url = 'autoloker://job-vacancies/550e8400-e29b-41d4-a716-446655440000';
        $newer = $this->notification($user, ['title' => 'Newer', 'url' => $url]);
        $this->notification($other, ['title' => 'Private', 'url' => 'autoloker://notifications']);

        $this->withToken($this->token($user))
            ->getJson('/api/notifications')
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonCount(2, 'data.notifications')
            ->assertJsonPath('data.notifications.0.uuid', $newer->uuid)
            ->assertJsonPath('data.notifications.0.url', $url)
            ->assertJsonPath('data.notifications.1.uuid', $older->uuid)
            ->assertJsonMissing(['title' => 'Private']);
    }

    public function test_history_filters_by_read_state_type_and_date_range(): void
    {
        $user = $this->user('filters@example.com');
        $match = $this->notification($user, [
            'title' => 'Match',
            'type' => 'lowongan',
            'is_read' => false,
            'created_at' => '2026-10-05 10:00:00',
        ]);
        $read = $this->notification($user, [
            'title' => 'Read',
            'type' => 'lowongan',
            'is_read' => true,
            'created_at' => '2026-10-05 11:00:00',
        ]);
        $this->notification($user, [
            'title' => 'Other Type',
            'type' => 'akun',
            'is_read' => false,
            'created_at' => '2026-10-05 12:00:00',
        ]);
        $this->notification($user, [
            'title' => 'Outside Date',
            'type' => 'lowongan',
            'is_read' => false,
            'created_at' => '2026-10-06 10:00:00',
        ]);

        $this->withToken($this->token($user))
            ->getJson('/api/notifications?is_read=0&type=lowongan&date_from=2026-10-05&date_to=2026-10-05')
            ->assertOk()
            ->assertJsonCount(1, 'data.notifications')
            ->assertJsonPath('data.notifications.0.uuid', $match->uuid);
        $this->withToken($this->token($user))
            ->getJson('/api/notifications?is_read=true&type=lowongan&date_from=2026-10-05&date_to=2026-10-05')
            ->assertOk()
            ->assertJsonCount(1, 'data.notifications')
            ->assertJsonPath('data.notifications.0.uuid', $read->uuid);
    }


    public function test_unread_count_and_read_actions_are_scoped_to_the_authenticated_user(): void
    {
        $user = $this->user('read-own@example.com');
        $other = $this->user('read-other@example.com');
        $own = $this->notification($user);
        $otherNotification = $this->notification($other);
        $token = $this->token($user);

        $this->withToken($token)
            ->getJson('/api/notifications/unread-count')
            ->assertOk()
            ->assertJsonPath('data.unread_count', 1);

        $this->withToken($token)
            ->postJson("/api/notifications/{$otherNotification->uuid}/read")
            ->assertNotFound()
            ->assertJsonPath('status', false);

        $this->withToken($token)
            ->postJson("/api/notifications/{$own->uuid}/read")
            ->assertOk()
            ->assertJsonPath('status', true);

        $this->assertDatabaseHas('notifications', [
            'id' => $own->id,
            'user_id' => $user->id,
            'is_read' => true,
        ]);
        $this->assertNotNull($own->fresh()->read_at);
        $this->assertDatabaseHas('notifications', [
            'id' => $otherNotification->id,
            'is_read' => false,
        ]);
    }

    public function test_mark_all_read_changes_only_the_callers_unread_notifications(): void
    {
        $user = $this->user('read-all@example.com');
        $other = $this->user('read-all-other@example.com');
        $ownFirst = $this->notification($user);
        $ownSecond = $this->notification($user);
        $otherRow = $this->notification($other);

        $this->withToken($this->token($user))
            ->postJson('/api/notifications/read-all')
            ->assertOk()
            ->assertJsonPath('status', true);

        foreach ([$ownFirst, $ownSecond] as $row) {
            $this->assertDatabaseHas('notifications', ['id' => $row->id, 'is_read' => true]);
            $this->assertNotNull($row->fresh()->read_at);
        }
        $this->assertDatabaseHas('notifications', ['id' => $otherRow->id, 'is_read' => false]);
    }

    public function test_notification_history_requires_api_authentication(): void
    {
        $this->getJson('/api/notifications')->assertUnauthorized()->assertJsonPath('status', false);
        $this->getJson('/api/notifications/unread-count')->assertUnauthorized()->assertJsonPath('status', false);
    }

    private function user(string $email): User
    {
        return User::create([
            'name' => 'History User',
            'email' => $email,
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
    }

    private function token(User $user): string
    {
        return app(TokenService::class)->issue($user)['access_token'];
    }

    private function notification(User $user, array $overrides = []): Notification
    {
        static $sequence = 0;
        $sequence++;

        return Notification::create(array_merge([
            'user_id' => $user->id,
            'title' => "Notification {$sequence}",
            'description' => 'History entry',
            'type' => 'akun',
            'is_read' => false,
        ], $overrides));
    }
}
