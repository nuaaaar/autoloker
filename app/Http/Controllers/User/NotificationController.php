<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request, NotificationService $notifications): View
    {
        $filters = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'type' => ['nullable', 'string'],
            'is_read' => ['nullable', 'boolean'],
        ]);

        return view('dashboard-user.notification.index', [
            'notifications' => $notifications->userNotifications($request->user()->id, 10, $filters),
            'unreadCount' => $notifications->unreadCount($request->user()->id),
        ]);
    }

    public function markRead(Request $request, NotificationService $notifications, string $uuid): RedirectResponse
    {
        if (! $notifications->markAsRead($uuid, auth()->id())) {
            return back()->with('error', 'Notifikasi tidak ditemukan.');
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead(NotificationService $notifications): RedirectResponse
    {
        $notifications->markAllAsRead(auth()->id());

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
