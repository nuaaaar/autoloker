<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\MasterBank;
use App\Models\MasterSubscription;
use App\Models\UserOrderManual;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserSubscriptionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX / RIWAYAT PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | SUBSCRIPTIONS
        |--------------------------------------------------------------------------
        */

        $subscriptions = MasterSubscription::where(
                'is_active',
                1
            )
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */

        $orders = UserOrderManual::with([
                'subscription',
                'userSubscription',
            ])
            ->where(
                'user_id',
                $user->id
            )
            ->orderByDesc('created_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ACTIVE SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $activeSubscription = UserSubscription::with([
                'subscription',
                'order',
            ])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where(function ($query) {

                $query->whereNull('expired_at')
                    ->orWhere(
                        'expired_at',
                        '>',
                        now()
                    );

            })
            ->orderByDesc('expired_at')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | CURRENT SUBSCRIPTION
        |--------------------------------------------------------------------------
        |
        | Alias untuk kebutuhan Blade.
        |
        */

        $currentSubscription = $activeSubscription;


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalOrders = $orders->count();

        $totalPaid = $orders
            ->whereNotNull('verified_at')
            ->sum('price');

        $pendingPayment = $orders
            ->where('status', 'pending_payment')
            ->first();

        $rejectedPayment = $orders
            ->where('status', 'rejected')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | BANK ACCOUNT
        |--------------------------------------------------------------------------
        */

        $bankAccounts = MasterBank::orderBy('bank_name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.user-subscription.index',
            compact(
                'subscriptions',
                'orders',
                'activeSubscription',
                'currentSubscription',
                'totalOrders',
                'totalPaid',
                'pendingPayment',
                'rejectedPayment',
                'bankAccounts'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalOrders = $orders->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PAID
        |--------------------------------------------------------------------------
        */

        $totalPaid = $orders
            ->whereNotNull('verified_at')
            ->sum('price');


        /*
        |--------------------------------------------------------------------------
        | PENDING PAYMENT
        |--------------------------------------------------------------------------
        */

        $pendingPayment = $orders
            ->where(
                'status',
                'pending_payment'
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | REJECTED PAYMENT
        |--------------------------------------------------------------------------
        */

        $rejectedPayment = $orders
            ->where(
                'status',
                'rejected'
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | BANK ACCOUNT
        |--------------------------------------------------------------------------
        */

        $bankAccounts = MasterBank::orderBy(
                'bank_name'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.subscription.index',
            compact(
                'subscriptions',
                'orders',
                'activeSubscription',
                'currentSubscription',
                'totalOrders',
                'totalPaid',
                'pendingPayment',
                'rejectedPayment',
                'bankAccounts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE ORDER
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'subscription_uuid' => 'required|string',
        ]);


        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | FIND SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = MasterSubscription::where(
                'uuid',
                $request->subscription_uuid
            )
            ->where(
                'is_active',
                1
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | GENERATE ORDER NUMBER
        |--------------------------------------------------------------------------
        */

        $orderNumber = $this->generateOrderNumber();


        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER
        |--------------------------------------------------------------------------
        */

        $order = UserOrderManual::create([

            'uuid' =>
                (string) Str::uuid(),

            'user_id' =>
                $user->id,

            'master_subscription_id' =>
                $subscription->id,

            'role' =>
                $subscription->role,

            'order_number' =>
                $orderNumber,

            'price' =>
                $subscription->price,

            'status' =>
                'pending_payment',

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Order berhasil dibuat.',

            'redirect' =>
                route(
                    'user-page.subscription.index'
                ),

            'order_uuid' =>
                $order->uuid,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPLOAD PAYMENT PROOF
    |--------------------------------------------------------------------------
    */

    public function uploadProof(
        Request $request,
        $uuid
    ) {

        $request->validate([

            'payment_method' =>
                'required|string|max:50',

            'payment_account' =>
                'nullable|string|max:100',

            'payment_date' =>
                'required|date',

            'payment_proof' =>
                'required|file|mimes:jpg,jpeg,png,pdf|max:5120',

        ]);


        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | FIND ORDER
        |--------------------------------------------------------------------------
        */

        $order = UserOrderManual::where(
                'uuid',
                $uuid
            )
            ->where(
                'user_id',
                $user->id
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | ONLY PENDING / REJECTED
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $order->status,
                [
                    'pending_payment',
                    'rejected',
                ]
            )
        ) {

            return back()->with(
                'ERR',
                'Order ini tidak dapat mengirim bukti pembayaran.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FILE
        |--------------------------------------------------------------------------
        */

        $fileName =
            time() .
            '_' .
            Str::random(10) .
            '.' .
            $request
                ->file('payment_proof')
                ->getClientOriginalExtension();


        $request
            ->file('payment_proof')
            ->storeAs(
                'public/payment-proofs',
                $fileName
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER
        |--------------------------------------------------------------------------
        */

        $order->update([

            'payment_method' =>
                $request->payment_method,

            'payment_account' =>
                $request->payment_account,

            'payment_date' =>
                $request->payment_date,

            'file' =>
                'payment-proofs/' . $fileName,

            'status' =>
                'verification',

            'rejected_reason' =>
                null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'OK',
            'Bukti pembayaran berhasil dikirim dan menunggu verifikasi.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ORDER NUMBER
    |--------------------------------------------------------------------------
    */

    private function generateOrderNumber()
    {
        $prefix =
            'ORD-' .
            now()->format('Y') .
            '-';


        $lastOrder = UserOrderManual::where(
                'order_number',
                'like',
                $prefix . '%'
            )
            ->orderByDesc('id')
            ->first();


        if (!$lastOrder) {

            $number = 1;

        } else {

            $lastNumber =
                (int) str_replace(
                    $prefix,
                    '',
                    $lastOrder->order_number
                );

            $number =
                $lastNumber + 1;
        }


        return $prefix .
            str_pad(
                $number,
                5,
                '0',
                STR_PAD_LEFT
            );
    }
}