<?php

namespace Tests\Feature\Jobs;

use App\Jobs\SendFcmNotification;
use App\Models\MasterNotification;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserDeviceToken;
use App\Services\Fcm\FcmSender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class SendFcmNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_sends_notification_to_enabled_mobile_tokens(): void
    {
        $user = $this->user();
        $master = $this->master(['push_enabled' => true, 'mobile_enabled' => true, 'web_enabled' => true]);
        $notification = $this->notification($user, $master);
        $this->token($user, 'mobile-token', 'mobile');
        $sender = Mockery::mock(FcmSender::class);
        $sender->shouldReceive('send')
            ->once()
            ->with($notification->title, $notification->description, [
                'code' => $master->code,
                'notification_uuid' => $notification->uuid,
                'url' => '',
            ], ['mobile-token']);
        $this->app->instance(FcmSender::class, $sender);

        (new SendFcmNotification($notification->id))->handle();
    }

    public function test_job_excludes_web_tokens_when_web_push_is_disabled(): void
    {
        $user = $this->user();
        $master = $this->master(['push_enabled' => true, 'mobile_enabled' => true, 'web_enabled' => false]);
        $notification = $this->notification($user, $master);
        $this->token($user, 'mobile-token', 'mobile');
        $this->token($user, 'web-token', 'web');
        $sender = Mockery::mock(FcmSender::class);
        $sender->shouldReceive('send')->once()->withArgs(fn ($title, $body, $data, $tokens) => $tokens === ['mobile-token']);
        $this->app->instance(FcmSender::class, $sender);

        (new SendFcmNotification($notification->id))->handle();
    }

    public function test_job_does_not_resolve_sender_when_no_eligible_tokens_or_push_disabled(): void
    {
        $user = $this->user();
        $master = $this->master(['push_enabled' => true, 'mobile_enabled' => false, 'web_enabled' => false]);
        $notification = $this->notification($user, $master);
        $this->token($user, 'mobile-token', 'mobile');
        $sender = Mockery::mock(FcmSender::class);
        $sender->shouldNotReceive('send');
        $this->app->instance(FcmSender::class, $sender);

        (new SendFcmNotification($notification->id))->handle();

        $master->update(['push_enabled' => false]);
        (new SendFcmNotification($notification->id))->handle();
    }

    public function test_job_returns_for_missing_notification(): void
    {
        $sender = Mockery::mock(FcmSender::class);
        $sender->shouldNotReceive('send');
        $this->app->instance(FcmSender::class, $sender);

        (new SendFcmNotification(999))->handle();
    }

    private function user(): User
    {
        return User::create([
            'name' => 'FCM User',
            'email' => 'fcm-user@example.com',
            'google_id' => null,
            'password' => 'password',
            'role' => 'satpam',
            'status' => 'active',
        ]);
    }

    private function master(array $overrides = []): MasterNotification
    {
        return MasterNotification::create(array_merge([
            'code' => 'fcm-test',
            'name' => 'FCM Test',
            'category' => 'akun',
            'title_template' => 'Title',
            'message_template' => 'Body',
            'push_enabled' => true,
            'mobile_enabled' => true,
            'web_enabled' => true,
            'is_active' => true,
        ], $overrides));
    }

    private function notification(User $user, MasterNotification $master): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'notification_id' => $master->id,
            'title' => 'Title',
            'description' => 'Body',
            'is_read' => false,
        ]);
    }

    private function token(User $user, string $token, string $platform): void
    {
        UserDeviceToken::create([
            'user_id' => $user->id,
            'fcm_token' => $token,
            'fcm_token_hash' => hash('sha256', $token),
            'platform' => $platform,
        ]);
    }
}
