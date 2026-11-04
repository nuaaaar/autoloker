<?php

namespace App\Services;

use App\Jobs\SendFcmNotification;
use App\Models\MasterNotification;
use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Indonesian display labels for job application statuses.
     */
    public const JOB_STATUS_LABELS = [
        'applied' => 'dikirim',
        'reviewed' => 'sedang direview',
        'shortlisted' => 'lolos seleksi',
        'rejected' => 'ditolak',
    ];

    /**
     * Indonesian display labels for training application statuses.
     */
    public const TRAINING_STATUS_LABELS = [
        'pending' => 'menunggu konfirmasi',
        'approved' => 'disetujui',
        'rejected' => 'ditolak',
    ];

    /**
     * Create a notification history row from the master template.
     *
     * Templates interpolate ":placeholder" params. Returns null (no row,
     * no push) when the master code is missing or inactive.
     */
    
    public function send(
        int $userId,
        string $code,
        array $params = []
    ): ?Notification {

        /*
        |--------------------------------------------------------------------------
        | GET MASTER NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $master = MasterNotification::query()
            ->where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$master) {
            Log::warning("Master notification [{$code}] not found or inactive.");

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | INTERPOLATE TEMPLATES
        |--------------------------------------------------------------------------
        */

        $replacements = collect($params)
            ->mapWithKeys(fn ($value, $key) => [
                ":{$key}" => (string) $value
            ])
            ->all();

        /*
        |--------------------------------------------------------------------------
        | FLUTTER & WEB ROUTING
        |--------------------------------------------------------------------------
        */

        $flutterUrl = $master->flutter_route
            ? strtr($master->flutter_route, $replacements)
            : null;

        $webUrl = $master->dashboard_route
            ? strtr($master->dashboard_route, $replacements)
            : null;

        /*
        |--------------------------------------------------------------------------
        | CREATE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $notification = Notification::create([
            'uuid' => (string) Str::uuid(),

            'user_id' => $userId,

            'notification_id' => $master->id,

            'title' => strtr(
                $master->title_template,
                $replacements
            ),

            'description' => strtr(
                $master->message_template,
                $replacements
            ),

            'url' => $flutterUrl,

            'url_web' => $webUrl,

            'type' => $master->category,

            'is_read' => false,

            'read_at' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | QUEUE FCM PUSH
        |--------------------------------------------------------------------------
        */

        if ($master->push_enabled) {
            SendFcmNotification::dispatch($notification->id);
        }

        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL
        |--------------------------------------------------------------------------
        */

        if (
            $master->email_enabled &&
            !empty($master->email_subject) &&
            !empty($master->email_template)
        ) {
            try {
                $user = User::find($userId);

                if ($user && !empty($user->email)) {

                    $emailSubject = strtr(
                        $master->email_subject,
                        $replacements
                    );

                    $emailBody = strtr(
                        $master->email_template,
                        $replacements
                    );

                    Mail::html($emailBody, function ($message) use (
                        $user,
                        $emailSubject
                    ) {
                        $message->to($user->email)
                            ->subject($emailSubject);
                    });

                } else {
                    Log::warning(
                        "Notification email skipped. User [{$userId}] has no email address."
                    );
                }

            } catch (\Throwable $e) {
                Log::error('Failed to send notification email.', [
                    'user_id' => $userId,
                    'notification_code' => $code,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $notification;
    }


    /**
     * Mark notification as read.
     */
    public function markAsRead(
        string $uuid,
        int $userId
    ): ?Notification {
        $notification = Notification::query()
            ->where('uuid', $uuid)
            ->where('user_id', $userId)
            ->first();

        if (!$notification) {
            return null;
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return $notification;
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(int $userId): int
    {
        return Notification::query()
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Get unread notification count.
     */
    public function unreadCount(int $userId): int
    {
        return Notification::query()
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get the user's notification history, newest first.
     */
    public function userNotifications(
        int $userId,
        int $perPage = 10,
        array $filters = []
    ): LengthAwarePaginator {
        $query = Notification::query()
            ->where('user_id', $userId)
            ->orderByDesc('id');

        if (isset($filters['is_read']) && $filters['is_read'] !== null) {
            $query->where('is_read', (bool) $filters['is_read']);
        }

        if (isset($filters['type']) && $filters['type'] !== null) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['date_from']) && $filters['date_from'] !== null) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to'] !== null) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate($perPage);
    }
}
