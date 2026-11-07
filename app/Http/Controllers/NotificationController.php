<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markRead($uuid)
    {
        $notification = Notification::where('uuid', $uuid)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        if ($notification->url_web) {
            return redirect()->to($notification->url_web);
        }

        return redirect()->route('user-page.notification.index');
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi berhasil ditandai dibaca.',
        ]);
    }

    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        $unreadNotificationCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('user-page.notif.index', compact(
            'notifications',
            'unreadNotificationCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
