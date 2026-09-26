<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserSubscriptionResource;
use App\Models\JobApplication;
use App\Models\TrainingApplication;
use App\Models\UserSubscription;
use App\Models\MasterSubscription;
use Illuminate\Database\Eloquent\Builder;
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
                ->where('user_id', $request->user()->getKey())
                ->where('role', $role)
                ->active()
                ->orderByDesc('expired_at')
                ->orderByDesc('id')
                ->first();

        $subscription ??= $role === null
            ? null
            : $this->defaultSubscription($request, $role);
        $subscription?->setAttribute('limit_usage', $this->limitUsage($request));

        return response()->json([
            'status' => true,
            'data' => [
                'user_subscription' => $subscription
                    ? (new UserSubscriptionResource($subscription))->resolve($request)
                    : null,
            ],
        ]);
    }

    private function limitUsage(Request $request): array
    {
        $security = $request->user()?->user_security?->security;

        if (! $security) {
            return [
                'total_active_job_applications' => 0,
                'total_active_training_applications' => 0,
            ];
        }

        return [
            'total_active_job_applications' => JobApplication::query()
                ->where('security_id', $security->getKey())
                ->whereHas('job_vacancy', function (Builder $query): void {
                    $query->where('status', 'published');
                })
                ->count(),
            'total_active_training_applications' => TrainingApplication::query()
                ->where('security_id', $security->getKey())
                ->whereHas('training', function (Builder $query): void {
                    $query->where('status', 'published');
                })
                ->count(),
        ];
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

        return $subscription;
    }
}
