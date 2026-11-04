<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DashboardUserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer([
            'layouts.dashboard-user',
        ], function ($view) {

            $user = Auth::user();

            $notifications = collect();
            $unreadNotificationCount = 0;

            if ($user) {
                $notifications = Notification::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

                $unreadNotificationCount = Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->count();
            }

            $view->with([
                'headerNotifications' => $notifications,
                'unreadNotificationCount' => $unreadNotificationCount,
            ]);
        });
    }
}