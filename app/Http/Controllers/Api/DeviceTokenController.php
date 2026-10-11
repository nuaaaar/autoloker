<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeviceTokenRequest;
use App\Models\UserDeviceToken;
use Illuminate\Http\JsonResponse;

class DeviceTokenController extends Controller
{
    public function store(DeviceTokenRequest $request): JsonResponse
    {
        $token = $request->validated('fcm_token');

        UserDeviceToken::updateOrCreate(
            ['fcm_token_hash' => hash('sha256', $token)],
            [
                'user_id' => $request->user()->id,
                'fcm_token' => $token,
                'platform' => $request->validated('platform') ?? 'mobile',
            ],
        );

        return response()->json([
            'status' => true,
            'message' => 'Token perangkat berhasil didaftarkan.',
        ]);
    }

    public function unregister(DeviceTokenRequest $request): JsonResponse
    {
        UserDeviceToken::query()
            ->where('user_id', $request->user()->id)
            ->where('fcm_token_hash', hash('sha256', $request->validated('fcm_token')))
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Token perangkat berhasil dihapus.',
        ]);
    }
}
