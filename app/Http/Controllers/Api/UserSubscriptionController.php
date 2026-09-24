<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserSubscriptionResource;
use App\Models\UserSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    public function active(Request $request): JsonResponse
    {
        $subscription = UserSubscription::query()
            ->with('subscription')
            ->where('user_id', $request->user()->getKey())
            ->active()
            ->orderByDesc('expired_at')
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'status' => true,
            'data' => [
                'user_subscription' => $subscription
                    ? (new UserSubscriptionResource($subscription))->resolve($request)
                    : null,
            ],
        ]);
    }
}
