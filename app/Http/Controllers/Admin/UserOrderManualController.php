<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BUJP;
use App\Models\Company;
use App\Models\UserOrderManual;
use App\Services\NotificationService;
use App\Services\TokenBillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserOrderManualController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(strtolower((string) Auth::user()?->role) === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();
        if (! $request->ajax()) {
            return view('dashboard-admin.payment.index');
        }
        $query = UserOrderManual::with(['user', 'subscription', 'tokenWallet'])->latest('id');
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('start_date')) {
            $query->where('payment_date', '>=', $request->date('start_date')->startOfDay());
        }
        if ($request->filled('end_date')) {
            $query->where('payment_date', '<=', $request->date('end_date')->endOfDay());
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")->orWhere('payment_method', 'like', "%{$search}%")->orWhere('role', 'like', "%{$search}%")->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))->orWhereHas('subscription', fn ($s) => $s->where('name', 'like', "%{$search}%"));
            });
        }
        $page = max(1, (int) $request->input('page', 1));
        $results = $query->paginate(min(100, max(1, (int) $request->input('length', 10))), ['*'], 'page', $page);
        $items = collect($results->items())->map(function (UserOrderManual $order) {
            $organization = null;
            if ($order->tokenWallet) {
                $organization = $order->tokenWallet->owner_type === 'company' ? Company::find($order->tokenWallet->owner_id) : BUJP::find($order->tokenWallet->owner_id);
            }
            $order->setAttribute('organization', $organization ? ['name' => $organization->company_name ?? ''] : null);

            return $order;
        });

        return response()->json(['results' => ['total' => $results->total(), 'data' => $items]]);
    }

    public function approve(Request $request, string $uuid, TokenBillingService $billing)
    {
        $this->authorizeAdmin();
        $order = UserOrderManual::where('uuid', $uuid)->firstOrFail();
        try {
            $wasApproved = DB::transaction(function () use ($order, $billing) {
                $locked = UserOrderManual::whereKey($order->id)->lockForUpdate()->firstOrFail();
                if ($locked->status === 'approved' && $locked->token_wallet_id) {
                    $billing->creditOrder($locked);

                    return true;
                }
                if ($locked->status !== 'verification' || ($locked->expired_at && ! $locked->expired_at->isFuture())) {
                    throw ValidationException::withMessages(['order' => 'Pembayaran tidak dapat diproses.']);
                }
                $locked->verified_by = Auth::id();
                $locked->save();
                $billing->creditOrder($locked);

                return false;
            });
            if (! $wasApproved && $order->master_subscription_id === null) {
                try {
                    app(NotificationService::class)->send($order->user_id, 'order_token_approved', ['tokens' => (string) $order->token_quantity, 'order_uuid' => rawurlencode((string) $order->uuid)]);
                } catch (\Throwable $e) {
                    Log::warning('Token approval notification failed', ['order_id' => $order->id]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Pembayaran disetujui dan token telah ditambahkan.']);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function reject(Request $request, string $uuid)
    {
        $this->authorizeAdmin();
        $data = $request->validate(['rejected_reason' => ['required', 'string', 'max:1000']]);
        $order = DB::transaction(function () use ($uuid, $data) {
            $order = UserOrderManual::where('uuid', $uuid)->lockForUpdate()->firstOrFail();
            if ($order->master_subscription_id !== null || $order->token_wallet_id === null || $order->token_quantity === null) {
                abort(422, 'Riwayat pesanan lama hanya dapat dibaca.');
            }
            if ($order->status !== 'verification' || ($order->expired_at && ! $order->expired_at->isFuture())) {
                abort(422, 'Pembayaran tidak dapat diproses.');
            }
            $order->update(['status' => 'rejected', 'rejected_reason' => $data['rejected_reason'], 'verified_by' => Auth::id(), 'verified_at' => now()]);

            return $order;
        });
        if ($order->master_subscription_id === null) {
            try {
                app(NotificationService::class)->send($order->user_id, 'order_token_rejected', ['tokens' => (string) $order->token_quantity, 'reason' => $order->rejected_reason, 'order_uuid' => rawurlencode((string) $order->uuid)]);
            } catch (\Throwable $e) {
                Log::warning('Token rejection notification failed', ['order_id' => $order->id]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil ditolak.']);
    }

    public function show(Request $request, string $uuid)
    {
        $this->authorizeAdmin();
        $payment = UserOrderManual::with(['user', 'subscription', 'tokenWallet'])->where('uuid', $uuid)->firstOrFail();
        $organization = null;
        if ($payment->tokenWallet) {
            $organization = $payment->tokenWallet->owner_type === 'company' ? Company::find($payment->tokenWallet->owner_id) : BUJP::find($payment->tokenWallet->owner_id);
        }
        $payment->setAttribute('organization', $organization ? ['name' => $organization->company_name ?? ''] : null);

        return response()->json(['success' => true, 'data' => $payment]);
    }
}
