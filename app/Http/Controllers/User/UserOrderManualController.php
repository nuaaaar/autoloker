<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TokenSetting;
use App\Models\TokenWallet;
use App\Models\UserOrderManual;
use App\Services\TokenBillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserOrderManualController extends Controller
{
    public function store(Request $request, TokenBillingService $billing)
    {
        $validated = $request->validate(['token_quantity' => ['required', 'integer', 'min:1', 'max:4294967295']]);
        $owner = $billing->ownerFor($request->user());
        $wallet = $billing->walletFor($owner);
        $settings = TokenSetting::current();
        $quantity = (int) $validated['token_quantity'];
        $rate = (int) $settings->idr_per_token;
        if ($quantity > intdiv(9_999_999_999_999, $rate)) {
            return back()->withErrors(['token_quantity' => 'Jumlah token melebihi batas transaksi.'])->withInput();
        }
        $price = $quantity * $rate;
        $order = DB::transaction(function () use ($request, $owner, $wallet, $quantity, $rate, $price) {
            $lockedWallet = TokenWallet::whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $pending = UserOrderManual::where('token_wallet_id', $lockedWallet->id)->where('status', 'pending_payment')->where(fn ($query) => $query->whereNull('expired_at')->orWhere('expired_at', '>', now()))->latest('id')->first();
            if ($pending) {
                return $pending;
            }

            return UserOrderManual::create(['user_id' => $request->user()->id, 'token_wallet_id' => $lockedWallet->id, 'token_quantity' => $quantity, 'idr_per_token' => $rate, 'master_subscription_id' => null, 'role' => $owner['column'] === 'company_id' ? 'client' : 'bujp', 'order_number' => $this->generateOrderNumber(), 'price' => $price, 'status' => 'pending_payment']);
        });
        if ($request->expectsJson()) {
            return response()->json(['success' => $order->wasRecentlyCreated, 'code' => $order->wasRecentlyCreated ? null : 'pending_payment_order_exists', 'message' => $order->wasRecentlyCreated ? 'Pesanan token berhasil dibuat.' : 'Masih ada pesanan token yang menunggu pembayaran.', 'data' => ['user_order_manual' => array_merge($order->toArray(), ['price' => (int) $order->price])]], $order->wasRecentlyCreated ? 201 : 409);
        }

        return redirect()->route('dashboard-user.tokens.index')->with($order->wasRecentlyCreated ? 'OK' : 'ERR', $order->wasRecentlyCreated ? 'Pesanan token berhasil dibuat.' : 'Selesaikan atau batalkan pesanan token yang masih menunggu pembayaran.');
    }

    public function cancel(Request $request, string $uuid)
    {
        $owner = app(TokenBillingService::class)->ownerFor($request->user());
        $wallet = app(TokenBillingService::class)->walletFor($owner);
        $result = DB::transaction(function () use ($uuid, $wallet) {
            $order = UserOrderManual::where('uuid', $uuid)->where('token_wallet_id', $wallet->id)->lockForUpdate()->firstOrFail();
            if ($order->status !== 'pending_payment') {
                abort(409, 'Pesanan tidak dapat dibatalkan.');
            }
            $order->update(['status' => 'cancelled']);

            return $order;
        });

        return $request->expectsJson() ? response()->json(['success' => true, 'data' => ['user_order_manual' => $result]]) : back()->with('OK', 'Pesanan dibatalkan.');
    }

    public function uploadProof(Request $request, string $uuid)
    {
        $owner = app(TokenBillingService::class)->ownerFor($request->user());
        $wallet = app(TokenBillingService::class)->walletFor($owner);
        $data = $request->validate(['payment_method' => ['required', 'string', 'max:50'], 'payment_account' => ['nullable', 'string', 'max:255'], 'payment_date' => ['required', 'date'], 'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120']]);
        $file = $request->file('payment_proof');
        $directory = public_path('uploads/payment');
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to prepare payment storage.');
        }
        [$order, $previous] = DB::transaction(function () use ($uuid, $wallet, $data, $file, $directory) {
            $order = UserOrderManual::where('uuid', $uuid)->where('token_wallet_id', $wallet->id)->lockForUpdate()->firstOrFail();
            if (! in_array($order->status, ['pending_payment', 'rejected'], true) || ($order->expired_at && ! $order->expired_at->isFuture())) {
                abort(404, 'Pesanan tidak ditemukan atau telah kedaluwarsa.');
            }
            $filename = 'payment_'.$order->order_number.'_'.now()->timestamp.'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $previous = $order->file;
            $order->update(['payment_method' => $data['payment_method'], 'payment_account' => $data['payment_account'] ?? null, 'payment_date' => $data['payment_date'], 'file' => $filename, 'status' => 'verification', 'rejected_reason' => null]);

            return [$order, $previous];
        });
        if ($previous && is_file($directory.'/'.basename($previous))) {
            unlink($directory.'/'.basename($previous));
        }

        return $request->expectsJson() ? response()->json(['success' => true, 'data' => ['user_order_manual' => $order]]) : redirect()->route('dashboard-user.tokens.index')->with('OK', 'Bukti pembayaran berhasil dikirim untuk verifikasi.');
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('YmdHis').'-'.strtoupper(Str::random(5));
        } while (UserOrderManual::where('order_number', $number)->exists());

        return $number;
    }
}
