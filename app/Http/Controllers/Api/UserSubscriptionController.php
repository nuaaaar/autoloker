<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserSubscriptionResource;
use App\Models\UserSubscription;
use App\Models\MasterSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    private const ROLE_MAPPING = [
        'satpam' => 'security',
        'bujp' => 'bujp',
        'company' => 'client',
        'perusahaan' => 'client',
    ];

    public function active(Request $request): JsonResponse
    {
        $role = self::ROLE_MAPPING[
            strtolower(trim((string) $request->user()?->role))
        ] ?? null;

        $subscription = $role === null
            ? null
            : UserSubscription::query()
                ->with('subscription')
                ->where('user_id', $request->user()->getKey())
                ->where('role', $role)
                ->active()
                ->orderByDesc('expired_at')
                ->orderByDesc('id')
                ->first();

        $subscription ??= $role === null
            ? null
            : $this->defaultSubscription($request, $role);

        return response()->json([
            'status' => true,
            'data' => [
                'user_subscription' => $subscription
                    ? (new UserSubscriptionResource($subscription))->resolve($request)
                    : null,
            ],
        ]);
    }

    private function defaultSubscription(Request $request, string $role): ?UserSubscription
    {
        $default = MasterSubscription::query()
            ->where('role', $role)
            ->where('price', 0)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        if (! $default) {
            return null;
        }

        $startedAt = now();
        $expiredAt = match ($default->duration_type) {
            'day' => $startedAt->copy()->addDays($default->duration),
            'year' => $startedAt->copy()->addYears($default->duration),
            default => $startedAt->copy()->addMonths($default->duration),
        };

        $subscription = new UserSubscription([
            'uuid' => $default->uuid,
            'user_id' => $request->user()->getKey(),
            'master_subscription_id' => $default->getKey(),
            'user_order_manual_id' => null,
            'role' => $default->role,
            'subscription_name' => $default->name,
            'price' => $default->price,
            'started_at' => $startedAt,
            'expired_at' => $expiredAt,
            'status' => 'active',
            'limits' => $default->features,
            'notes' => null,
            'cancelled_at' => null,
        ]);
        $subscription->setRelation('subscription', $default);

        return $subscription;
    }
}
