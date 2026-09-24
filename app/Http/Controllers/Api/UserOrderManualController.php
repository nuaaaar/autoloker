<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserOrderManualIndexRequest;
use App\Http\Requests\Api\UserOrderManualStoreRequest;
use App\Http\Resources\Api\UserOrderManualResource;
use App\Models\MasterSubscription;
use App\Models\UserOrderManual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UserOrderManualController extends Controller
{
    private const PER_PAGE = 5;

    private const ROLE_MAPPING = [
        'satpam' => 'security',
        'bujp' => 'bujp',
        'company' => 'client',
        'perusahaan' => 'client',
    ];

    public function index(UserOrderManualIndexRequest $request): JsonResponse
    {
        $orders = UserOrderManual::query()
            ->with('subscription')
            ->where('user_id', $request->user()->getKey())
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'data' => [
                'user_order_manuals' => UserOrderManualResource::collection($orders->items())->resolve(),
                'pagination' => $this->pagination($orders),
            ],
        ]);
    }

    public function store(UserOrderManualStoreRequest $request): JsonResponse
    {
        $role = self::ROLE_MAPPING[strtolower(trim($request->user()->role))] ?? null;

        if (! $role) {
            return response()->json([
                'status' => false,
                'message' => 'User role is not valid for subscription orders.',
                'data' => null,
            ], 422);
        }

        $subscription = MasterSubscription::query()
            ->where('uuid', $request->validated('subscription_uuid'))
            ->where('role', $role)
            ->where('is_active', true)
            ->first();

        if (! $subscription) {
            return response()->json([
                'status' => false,
                'message' => 'Subscription plan not found.',
                'data' => null,
            ], 404);
        }

        if (strtolower(trim((string) $subscription->slug)) === 'dasar') {
            return response()->json([
                'status' => false,
                'message' => 'The Dasar plan is free and does not require an order.',
                'data' => null,
            ], 422);
        }

        $pendingOrder = UserOrderManual::query()
            ->with('subscription')
            ->where('user_id', $request->user()->getKey())
            ->where('master_subscription_id', $subscription->getKey())
            ->where('status', 'pending_payment')
            ->latest('id')
            ->first();

        if ($pendingOrder) {
            return response()->json([
                'status' => true,
                'message' => 'You already have an order waiting for payment.',
                'data' => [
                    'user_order_manual' => (new UserOrderManualResource($pendingOrder))->resolve($request),
                ],
            ]);
        }

        $order = UserOrderManual::create([
            'user_id' => $request->user()->getKey(),
            'master_subscription_id' => $subscription->getKey(),
            'role' => $role,
            'order_number' => $this->generateOrderNumber(),
            'price' => $subscription->price,
            'status' => 'pending_payment',
        ]);

        $order->load('subscription');

        return response()->json([
            'status' => true,
            'message' => 'Manual subscription order created successfully.',
            'data' => [
                'user_order_manual' => (new UserOrderManualResource($order))->resolve($request),
            ],
        ], 201);
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-'.now()->format('YmdHis').'-'.strtoupper(Str::random(5));
        } while (UserOrderManual::query()->where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    private function pagination(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'has_more' => $paginator->hasMorePages(),
            'next_page_url' => $paginator->nextPageUrl(),
            'previous_page_url' => $paginator->previousPageUrl(),
        ];
    }
}
