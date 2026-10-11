<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request, NotificationService $notifications): JsonResponse
    {
        $filters = $request->validate([
            'is_read' => ['nullable', 'boolean'],
            'type' => ['nullable', 'string'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $paginator = $notifications->userNotifications($request->user()->id, 10, $filters);

        return response()->json([
            'status' => true,
            'message' => 'Data notifikasi berhasil diambil.',
            'data' => [
                'notifications' => NotificationResource::collection($paginator->items())->resolve(),
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ],
            ],
        ]);
    }

    public function unreadCount(Request $request, NotificationService $notifications): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Jumlah notifikasi belum dibaca berhasil diambil.',
            'data' => ['unread_count' => $notifications->unreadCount($request->user()->id)],
        ]);
    }

    public function markRead(Request $request, NotificationService $notifications, string $uuid): JsonResponse
    {
        if (! $notifications->markAsRead($uuid, $request->user()->id)) {
            return response()->json([
                'status' => false,
                'message' => 'Notifikasi tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Notifikasi berhasil ditandai sudah dibaca.',
        ]);
    }

    public function markAllRead(Request $request, NotificationService $notifications): JsonResponse
    {
        $notifications->markAllAsRead($request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Semua notifikasi berhasil ditandai sudah dibaca.',
        ]);
    }
}
