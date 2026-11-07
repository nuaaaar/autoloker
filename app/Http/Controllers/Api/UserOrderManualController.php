<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserOrderManualIndexRequest;
use App\Http\Requests\Api\UserOrderManualStoreRequest;
use App\Http\Resources\Api\UserOrderManualResource;
use App\Models\TokenSetting;
use App\Models\TokenWallet;
use App\Models\UserOrderManual;
use App\Services\TokenBillingService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserOrderManualController extends Controller
{
    private const PER_PAGE = 5;

    public function index(UserOrderManualIndexRequest $request, TokenBillingService $billing): JsonResponse
    {
        $wallet = $billing->walletFor($billing->ownerFor($request->user()));
        $orders = UserOrderManual::where('token_wallet_id', $wallet->id)->latest('id')->paginate(self::PER_PAGE)->withQueryString();

        return response()->json(['status' => true, 'data' => ['user_order_manuals' => UserOrderManualResource::collection($orders->items())->resolve(), 'pagination' => $this->pagination($orders)]]);
    }

    public function show(Request $request, string $uuid, TokenBillingService $billing): JsonResponse
    {
        $wallet = $billing->walletFor($billing->ownerFor($request->user()));
        $order = UserOrderManual::where('uuid', $uuid)->where('token_wallet_id', $wallet->id)->first();
        if (! $order) {
            return response()->json(['status' => false, 'message' => 'Pesanan tidak ditemukan.', 'data' => null], 404)->header('Cache-Control', 'no-store');
        }

        return response()->json(['status' => true, 'data' => ['user_order_manual' => (new UserOrderManualResource($order))->resolve($request)]])->header('Cache-Control', 'no-store');
    }

    public function store(UserOrderManualStoreRequest $request, TokenBillingService $billing): JsonResponse
    {
        $owner = $billing->ownerFor($request->user());
        $wallet = $billing->walletFor($owner);
        $settings = TokenSetting::current();
        $quantity = (int) $request->validated('token_quantity');
        $rate = (int) $settings->idr_per_token;
        if ($quantity > intdiv(9_999_999_999_999, $rate)) {
            throw ValidationException::withMessages(['token_quantity' => 'Jumlah token melebihi batas transaksi.']);
        }
        $orderResult = DB::transaction(function () use ($request, $owner, $wallet, $quantity, $rate) {
            $lockedWallet = TokenWallet::whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $pending = UserOrderManual::where('token_wallet_id', $lockedWallet->id)->where('status', 'pending_payment')->where(fn ($query) => $query->whereNull('expired_at')->orWhere('expired_at', '>', now()))->latest('id')->first();
            if ($pending) {
                return [$pending, false];
            }
            $created = UserOrderManual::create(['user_id' => $request->user()->id, 'token_wallet_id' => $lockedWallet->id, 'token_quantity' => $quantity, 'idr_per_token' => $rate, 'master_subscription_id' => null, 'role' => $owner['column'] === 'company_id' ? 'client' : 'bujp', 'order_number' => $this->generateOrderNumber(), 'price' => $quantity * $rate, 'status' => 'pending_payment']);

            return [$created, true];
        });
        [$order, $created] = $orderResult;

        return response()->json(['status' => $created, 'code' => $created ? null : 'pending_payment_order_exists', 'message' => $created ? 'Pesanan token berhasil dibuat.' : 'Masih ada pesanan token yang menunggu pembayaran.', 'data' => ['user_order_manual' => (new UserOrderManualResource($order))->resolve($request)]], $created ? 201 : 409);
    }

    public function cancel(Request $request, string $uuid, TokenBillingService $billing): JsonResponse
    {
        $wallet = $billing->walletFor($billing->ownerFor($request->user()));

        return DB::transaction(function () use ($request, $uuid, $wallet) {
            $order = UserOrderManual::where('uuid', $uuid)->where('token_wallet_id', $wallet->id)->lockForUpdate()->first();
            if (! $order) {
                return response()->json(['status' => false, 'message' => 'Pesanan tidak ditemukan.', 'data' => null], 404);
            }
            if ($order->status !== 'pending_payment') {
                return response()->json(['status' => false, 'code' => 'manual_order_not_cancellable', 'message' => 'Pesanan hanya dapat dibatalkan saat menunggu pembayaran.', 'data' => null], 409);
            }
            $order->update(['status' => 'cancelled']);

            return response()->json(['status' => true, 'data' => ['user_order_manual' => (new UserOrderManualResource($order))->resolve($request)]]);
        });
    }

    public function uploadProof(Request $request, string $uuid, TokenBillingService $billing): JsonResponse
    {
        $wallet = $billing->walletFor($billing->ownerFor($request->user()));
        $data = $request->validate(['payment_method' => ['required', 'string', 'max:50'], 'payment_account' => ['nullable', 'string', 'max:255'], 'payment_date' => ['required', 'date'], 'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120']]);
        $file = $request->file('payment_proof');
        $directory = public_path('uploads/payment');
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to prepare payment storage.');
        }
        [$order, $old] = DB::transaction(function () use ($uuid, $wallet, $data, $file, $directory) {
            $order = UserOrderManual::where('uuid', $uuid)->where('token_wallet_id', $wallet->id)->lockForUpdate()->first();
            if (! $order || ! in_array($order->status, ['pending_payment', 'rejected'], true) || ($order->expired_at && ! $order->expired_at->isFuture())) {
                abort(404, 'Pesanan tidak ditemukan atau telah kedaluwarsa.');
            }
            $filename = 'payment_'.$order->order_number.'_'.now()->timestamp.'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $old = $order->file;
            $order->update(['payment_method' => $data['payment_method'], 'payment_account' => $data['payment_account'] ?? null, 'payment_date' => $data['payment_date'], 'file' => $filename, 'status' => 'verification', 'rejected_reason' => null]);

            return [$order, $old];
        });
        if ($old && is_file($directory.'/'.basename($old))) {
            unlink($directory.'/'.basename($old));
        }

        return response()->json(['status' => true, 'message' => 'Bukti pembayaran menunggu verifikasi.', 'data' => ['user_order_manual' => (new UserOrderManualResource($order))->resolve($request)]]);
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('YmdHis').'-'.strtoupper(Str::random(5));
        } while (UserOrderManual::where('order_number', $number)->exists());

        return $number;
    }

    private function pagination(LengthAwarePaginator $paginator): array
    {
        return ['current_page' => $paginator->currentPage(), 'last_page' => $paginator->lastPage(), 'per_page' => $paginator->perPage(), 'total' => $paginator->total(), 'from' => $paginator->firstItem(), 'to' => $paginator->lastItem(), 'has_more_pages' => $paginator->hasMorePages()];
    }
}
