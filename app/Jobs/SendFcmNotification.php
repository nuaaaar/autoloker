<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\UserDeviceToken;
use App\Services\Fcm\FcmSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFcmNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly int $notificationId,
    ) {}

    public function handle(): void
    {
        $notification = Notification::find($this->notificationId);

        if (!$notification) {
            return;
        }

        $master = $notification->master;

        if (!$master?->push_enabled) {
            return;
        }

        $platforms = array_keys(array_filter([
            'mobile' => $master->mobile_enabled,
            'web' => $master->web_enabled,
        ]));

        if ($platforms === []) {
            return;
        }

        $tokens = UserDeviceToken::query()
            ->where('user_id', $notification->user_id)
            ->whereIn('platform', $platforms)
            ->pluck('fcm_token')
            ->all();

        if ($tokens === []) {
            return;
        }

        app(FcmSender::class)->send(
            $notification->title,
            $notification->description,
            [
                'code' => $master->code,
                'notification_uuid' => (string) $notification->uuid,
                'url' => (string) ($notification->url ?? ''),
            ],
            $tokens,
        );
    }
}
