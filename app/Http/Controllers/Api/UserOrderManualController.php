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
use Illuminate\Http\Request;
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

    public function show(Request $request, string $uuid): JsonResponse
    {
        $order = UserOrderManual::query()
            ->with('subscription')
            ->where('uuid', $uuid)
            ->where('user_id', $request->user()->getKey())
            ->first();

        if (! $order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.',
                'data' => null,
            ], 404)->header('Cache-Control', 'no-store');
        }

        return response()->json([
            'status' => true,
            'message' => 'Manual subscription order retrieved successfully.',
            'data' => [
                'user_order_manual' => (new UserOrderManualResource($order))->resolve($request),
            ],
        ])->header('Cache-Control', 'no-store');
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

    public function uploadProof(Request $request, string $uuid): JsonResponse
    {
        $order = UserOrderManual::query()
            ->with('subscription')
            ->where('uuid', $uuid)
            ->where('user_id', $request->user()->getKey())
            ->whereIn('status', ['pending_payment', 'rejected'])
            ->first();

        if (! $order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found or cannot accept payment proof.',
                'data' => null,
            ], 404);
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_account' => ['nullable', 'string', 'max:255'],
            'payment_date' => ['required', 'date'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $file = $request->file('payment_proof');
        $uploadPath = public_path('uploads/payment');

        if (! is_dir($uploadPath) && ! mkdir($uploadPath, 0755, true) && ! is_dir($uploadPath)) {
            throw new \RuntimeException('Unable to create payment upload directory.');
        }

        $filename = 'payment_'.$order->order_number.'_'.now()->timestamp.'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        $previousFilename = $order->file;
        $order->update([
            'payment_method' => $validated['payment_method'],
            'payment_account' => $validated['payment_account'] ?? null,
            'payment_date' => $validated['payment_date'],
            'file' => $filename,
            'status' => 'verification',
            'rejected_reason' => null,
        ]);
        $order->load('subscription');

        if ($previousFilename) {
            $previousPath = $uploadPath.'/'.basename($previousFilename);
            if (is_file($previousPath)) {
                unlink($previousPath);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Payment proof uploaded and is awaiting verification.',
            'data' => [
                'user_order_manual' => (new UserOrderManualResource($order))->resolve($request),
            ],
        ]);
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
