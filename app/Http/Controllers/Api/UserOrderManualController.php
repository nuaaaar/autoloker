<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserOrderManualIndexRequest;
use App\Http\Requests\Api\UserOrderManualStoreRequest;
use App\Http\Resources\Api\UserOrderManualResource;
use App\Models\MasterSubscription;
use App\Models\User;
use App\Models\UserOrderManual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'message' => 'Pesanan tidak ditemukan.',
                'data' => null,
            ], 404)->header('Cache-Control', 'no-store');
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail pesanan paket langganan berhasil dimuat.',
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
                'message' => 'Akun Anda tidak dapat memesan paket langganan.',
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
                'message' => 'Paket langganan tidak ditemukan, tidak aktif, atau tidak tersedia untuk peran akun Anda.',
                'data' => null,
            ], 404);
        }

        if (strtolower(trim((string) $subscription->slug)) === 'dasar') {
            return response()->json([
                'status' => false,
                'message' => 'Paket Dasar gratis dan tidak memerlukan pesanan.',
                'data' => null,
            ], 422);
        }

        $userId = $request->user()->getKey();

        return DB::transaction(function () use ($request, $subscription, $role, $userId): JsonResponse {
            $user = User::query()
                ->whereKey($userId)
                ->lockForUpdate()
                ->firstOrFail();

            $pendingOrder = UserOrderManual::query()
                ->with('subscription')
                ->where('user_id', $user->getKey())
                ->where('status', 'pending_payment')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            if ($pendingOrder) {
                return response()->json([
                    'status' => false,
                    'code' => 'pending_payment_order_exists',
                    'message' => 'Masih ada pesanan paket yang menunggu pembayaran. Selesaikan atau batalkan pesanan tersebut sebelum membuat pesanan baru.',
                    'data' => [
                        'user_order_manual' => (new UserOrderManualResource($pendingOrder))->resolve($request),
                    ],
                ], 409);
            }

            $order = UserOrderManual::create([
                'user_id' => $user->getKey(),
                'master_subscription_id' => $subscription->getKey(),
                'role' => $role,
                'order_number' => $this->generateOrderNumber(),
                'price' => $subscription->price,
                'status' => 'pending_payment',
            ]);

            $order->load('subscription');

            return response()->json([
                'status' => true,
                'message' => 'Pesanan paket langganan berhasil dibuat.',
                'data' => [
                    'user_order_manual' => (new UserOrderManualResource($order))->resolve($request),
                ],
            ], 201);
        });
    }

    public function cancel(Request $request, string $uuid): JsonResponse
    {
        return DB::transaction(function () use ($request, $uuid): JsonResponse {
            $order = UserOrderManual::query()
                ->where('uuid', $uuid)
                ->where('user_id', $request->user()->getKey())
                ->lockForUpdate()
                ->first();

            if (! $order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pesanan tidak ditemukan.',
                    'data' => null,
                ], 404);
            }

            if ($order->status !== 'pending_payment') {
                return response()->json([
                    'status' => false,
                    'code' => 'manual_order_not_cancellable',
                    'message' => 'Pesanan hanya dapat dibatalkan saat menunggu pembayaran.',
                    'data' => null,
                ], 409);
            }

            $order->update(['status' => 'cancelled']);
            $order->load('subscription');

            return response()->json([
                'status' => true,
                'message' => 'Pesanan paket langganan berhasil dibatalkan.',
                'data' => [
                    'user_order_manual' => (new UserOrderManualResource($order))->resolve($request),
                ],
            ]);
        });
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
                'message' => 'Pesanan tidak ditemukan atau tidak dapat menerima bukti pembayaran. Bukti hanya dapat diunggah saat pesanan menunggu pembayaran atau ditolak.',
                'data' => null,
            ], 404);
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_account' => ['nullable', 'string', 'max:255'],
            'payment_date' => ['required', 'date'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'payment_method.required' => 'Metode pembayaran wajib diisi.',
            'payment_method.string' => 'Metode pembayaran harus berupa teks.',
            'payment_method.max' => 'Metode pembayaran maksimal :max karakter.',
            'payment_account.string' => 'Nomor rekening pembayaran harus berupa teks.',
            'payment_account.max' => 'Nomor rekening pembayaran maksimal :max karakter.',
            'payment_date.required' => 'Tanggal pembayaran wajib diisi.',
            'payment_date.date' => 'Tanggal pembayaran harus berupa tanggal yang valid.',
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.file' => 'Bukti pembayaran harus berupa file.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berformat JPG, JPEG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 5 MB.',
        ]);

        $file = $request->file('payment_proof');
        $uploadPath = public_path('uploads/payment');

        if (! is_dir($uploadPath) && ! mkdir($uploadPath, 0755, true) && ! is_dir($uploadPath)) {
            throw new \RuntimeException('Gagal menyiapkan folder penyimpanan bukti pembayaran.');
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
            'message' => 'Bukti pembayaran berhasil diunggah dan menunggu verifikasi.',
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
