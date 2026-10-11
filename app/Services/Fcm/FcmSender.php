<?php

namespace App\Services\Fcm;

use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Throwable;

class FcmSender
{
    /**
     * Send one FCM message to the given device tokens.
     *
     * Resolves Firebase messaging lazily (only after the token list is
     * proven non-empty) so environments without credentials never touch
     * Firebase. Dead tokens (invalid/unknown to the project) are pruned.
     */
    public function send(string $title, string $description, array $data, array $tokens): void
    {
        if ($tokens === []) {
            return;
        }

        try {
            $messaging = app(Messaging::class);

            $message = CloudMessage::new()
                ->withNotification(Notification::create($title, $description))
                ->withData($data);

            $report = $messaging->sendMulticast($message, $tokens);

            $prunable = array_merge($report->invalidTokens(), $report->unknownTokens());

            if ($prunable !== []) {
                UserDeviceToken::query()
                    ->whereIn('fcm_token_hash', array_map(fn ($token) => hash('sha256', $token), $prunable))
                    ->delete();
            }
        } catch (Throwable $e) {
            Log::error('FCM send failed', ['error' => $e->getMessage()]);
        }
    }
}
