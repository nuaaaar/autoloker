<?php

namespace App\Services;

use App\Models\MasterNotification;
use App\Models\Notification;

class NotificationService
{
    /**
     * Create notification.
     */
    public function send(
        int $userId,
        string $code,
        ?string $type = null,
        ?string $title = null,
        ?string $description = null,
        ?string $url = null
    ): Notification {
        /*
        |--------------------------------------------------------------------------
        | GET MASTER NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $master = MasterNotification::query()
            ->where('code', $code)
            ->where('is_active', true)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | USE MASTER DATA
        |--------------------------------------------------------------------------
        */

        if ($master) {

            $title = $title ?? $master->title;

            $description = $description ?? $master->description;

            $type = $type ?? $master->type;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        return Notification::create([

            'user_id' => $userId,

            'notification_id' => $master?->id,

            'title' => $title,

            'description' => $description,

            'url' => $url,

            'type' => $type,

            'is_read' => false,

            'read_at' => null,

        ]);
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
     * Get user notifications.
     */
    public function getUserNotifications(
        int $userId,
        int $limit = 20
    ) {
        return Notification::query()
            ->where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();
    }


    /**
     * Delete notification.
     */
    public function delete(
        string $uuid,
        int $userId
    ): bool {
        $notification = Notification::query()
            ->where('uuid', $uuid)
            ->where('user_id', $userId)
            ->first();

        if (!$notification) {
            return false;
        }

        return (bool) $notification->delete();
    }


    /**
     * Delete all notifications.
     */
    public function deleteAll(int $userId): int
    {
        return Notification::query()
            ->where('user_id', $userId)
            ->delete();
    }
}