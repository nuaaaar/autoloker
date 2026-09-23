<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserOrderManual;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserSubscription;
use Illuminate\Support\Str;

class UserOrderManualController extends Controller
{
    private function calculateExpiredAt(
        $startDate,
        $duration,
        $durationType
    ) {
        $date = $startDate->copy();

        switch ($durationType) {

            case 'day':

                return $date->addDays(
                    $duration
                );

            case 'month':

                return $date->addMonthsNoOverflow(
                    $duration
                );

            case 'year':

                return $date->addYearsNoOverflow(
                    $duration
                );

            default:

                throw new \Exception(
                    'Tipe durasi subscription tidak valid.'
                );
        }
    }

    /**
     * List pembayaran manual
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATATABLE REQUEST
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            $query = UserOrderManual::query()
                ->with([
                    'user',
                    'subscription',
                ])

                /*
                |--------------------------------------------------------------------------
                | JANGAN TAMPILKAN ORDER YANG SUDAH EXPIRED
                |--------------------------------------------------------------------------
                */

                ->where(function ($q) {

                    $q->whereNull('expired_at')
                        ->orWhere(
                            'expired_at',
                            '>',
                            now()
                        );

                });


            /*
            |--------------------------------------------------------------------------
            | FILTER STATUS
            |--------------------------------------------------------------------------
            |
            | Status:
            |
            | pending_payment
            | verification
            | approved
            | rejected
            |
            */

            if ($request->filled('status')) {

                $query->where(
                    'status',
                    $request->status
                );

            }


            /*
            |--------------------------------------------------------------------------
            | FILTER START DATE
            |--------------------------------------------------------------------------
            */

            if ($request->filled('start_date')) {

                $startDate = Carbon::parse(
                    $request->start_date
                )->startOfDay();

                $query->where(
                    'payment_date',
                    '>=',
                    $startDate
                );

            }


            /*
            |--------------------------------------------------------------------------
            | FILTER END DATE
            |--------------------------------------------------------------------------
            */

            if ($request->filled('end_date')) {

                $endDate = Carbon::parse(
                    $request->end_date
                )->endOfDay();

                $query->where(
                    'payment_date',
                    '<=',
                    $endDate
                );

            }


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'order_number',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'payment_method',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'role',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    )

                    ->orWhereHas(
                        'subscription',
                        function ($subscriptionQuery) use ($search) {

                            $subscriptionQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | ORDER
            |--------------------------------------------------------------------------
            */

            $query->orderBy(
                'created_at',
                'desc'
            );


            /*
            |--------------------------------------------------------------------------
            | PAGINATION DATATABLE
            |--------------------------------------------------------------------------
            */

            $page = $request->get(
                'page',
                1
            );

            $length = $request->get(
                'length',
                10
            );


            $results = $query->paginate(
                $length,
                ['*'],
                'page',
                $page
            );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'results' => [
                    'total' => $results->total(),
                    'data' => $results->items(),
                ],
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-admin.payment.index'
        );
    }


    public function approve($uuid)
    {
        $order = UserOrderManual::with('subscription')
            ->where('uuid', $uuid)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        if ($order->status !== 'verification') {

            return response()->json([
                'success' => false,
                'message' => 'Order ini sudah diproses.'
            ], 422);

        }

        if ($order->expired_at && $order->expired_at->isPast()) {

            return response()->json([
                'success' => false,
                'message' => 'Order ini sudah expired.'
            ], 422);

        }

        if (!$order->subscription) {

            return response()->json([
                'success' => false,
                'message' => 'Master subscription tidak ditemukan.'
            ], 422);

        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | LOCK ORDER
            |--------------------------------------------------------------------------
            */

            $order = UserOrderManual::with('subscription')
                ->where('id', $order->id)
                ->lockForUpdate()
                ->first();

            if ($order->status !== 'verification') {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Order ini sudah diproses.'
                ], 422);

            }


            $masterSubscription = $order->subscription;


            /*
            |--------------------------------------------------------------------------
            | DURASI SUBSCRIPTION
            |--------------------------------------------------------------------------
            |
            | Mengikuti struktur:
            |
            | duration      = 30
            | duration_type = day
            |
            */

            $duration = (int) $masterSubscription->duration;

            $durationType = $masterSubscription->duration_type;


            if ($duration <= 0) {

                throw new \Exception(
                    'Durasi subscription belum dikonfigurasi.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CARI SUBSCRIPTION AKTIF USER
            |--------------------------------------------------------------------------
            */

            $currentSubscription = UserSubscription::query()
                ->where('user_id', $order->user_id)
                ->where('role', $order->role)
                ->where('status', 'active')
                ->whereNotNull('expired_at')
                ->where('expired_at', '>', now())
                ->orderByDesc('expired_at')
                ->lockForUpdate()
                ->first();


            /*
            |--------------------------------------------------------------------------
            | BELUM ADA SUBSCRIPTION AKTIF
            |--------------------------------------------------------------------------
            */

            if (!$currentSubscription) {

                $startedAt = now();

                $expiredAt = $this->calculateExpiredAt(
                    $startedAt,
                    $duration,
                    $durationType
                );

            }


            /*
            |--------------------------------------------------------------------------
            | SUDAH ADA SUBSCRIPTION AKTIF
            |--------------------------------------------------------------------------
            */

            else {

                /*
                |--------------------------------------------------------------------------
                | CEK PAKET YANG SAMA
                |--------------------------------------------------------------------------
                */

                $isSameSubscription =
                    (int) $currentSubscription->master_subscription_id
                    ===
                    (int) $order->master_subscription_id;


                /*
                |--------------------------------------------------------------------------
                | RENEW / PERPANJANG
                |--------------------------------------------------------------------------
                |
                | Paket sama:
                |
                | Lama:
                | 01 Sep - 30 Sep
                |
                | Beli lagi:
                | 20 Sep
                |
                | Hasil:
                | 01 Sep - 30 Okt
                |--------------------------------------------------------------------------
                */

                if ($isSameSubscription) {

                    $startedAt =
                        $currentSubscription->started_at;

                    $expiredAt =
                        $this->calculateExpiredAt(
                            $currentSubscription->expired_at,
                            $duration,
                            $durationType
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | UPGRADE / GANTI PAKET
                |--------------------------------------------------------------------------
                |
                | Paket lama:
                |
                | Basic
                | 01 Sep - 30 Sep
                |
                | Upgrade:
                |
                | Premium
                | 20 Sep
                |
                | Hasil:
                |
                | Premium
                | 20 Sep - 30 Okt
                |
                |--------------------------------------------------------------------------
                */

                else {

                    $startedAt = now();

                    /*
                    | Tambahkan durasi baru dari expiry
                    | subscription lama.
                    */

                    $expiredAt =
                        $this->calculateExpiredAt(
                            $currentSubscription->expired_at,
                            $duration,
                            $durationType
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | NONAKTIFKAN SUBSCRIPTION LAMA
                    |--------------------------------------------------------------------------
                    */

                    $currentSubscription->update([

                        'status' => 'cancelled',

                        'cancelled_at' => now(),

                        'notes' => trim(
                            ($currentSubscription->notes
                                ? $currentSubscription->notes . "\n"
                                : '')
                            .
                            'Digantikan oleh subscription baru melalui order '
                            .
                            $order->order_number
                        ),

                    ]);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | CREATE USER SUBSCRIPTION
            |--------------------------------------------------------------------------
            */

            $userSubscription = UserSubscription::create([

                'uuid' =>
                    (string) Str::uuid(),

                'user_id' =>
                    $order->user_id,

                'master_subscription_id' =>
                    $order->master_subscription_id,

                'user_order_manual_id' =>
                    $order->id,

                'role' =>
                    $order->role,

                /*
                |--------------------------------------------------------------------------
                | SNAPSHOT MASTER
                |--------------------------------------------------------------------------
                */

                'subscription_name' =>
                    $masterSubscription->name,

                'price' =>
                    $order->price,

                /*
                |--------------------------------------------------------------------------
                | PERIODE
                |--------------------------------------------------------------------------
                */

                'started_at' =>
                    $startedAt,

                'expired_at' =>
                    $expiredAt,

                'status' =>
                    'active',

                /*
                |--------------------------------------------------------------------------
                | SNAPSHOT FEATURES
                |--------------------------------------------------------------------------
                */

                'limits' =>
                    $masterSubscription->features,

                'notes' =>
                    $order->notes,

            ]);


            /*
            |--------------------------------------------------------------------------
            | APPROVE ORDER
            |--------------------------------------------------------------------------
            */

            $order->update([

                'status' =>
                    'approved',

                'verified_by' =>
                    Auth::id(),

                'verified_at' =>
                    now(),

                'rejected_reason' =>
                    null,

            ]);


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'message' =>
                    'Pembayaran berhasil disetujui dan subscription user telah diaktifkan.',

                'data' => [

                    'subscription_uuid' =>
                        $userSubscription->uuid,

                    'subscription_name' =>
                        $userSubscription->subscription_name,

                    'started_at' =>
                        $userSubscription->started_at
                            ? $userSubscription->started_at
                                ->format('d-m-Y H:i')
                            : null,

                    'expired_at' =>
                        $userSubscription->expired_at
                            ? $userSubscription->expired_at
                                ->format('d-m-Y H:i')
                            : null,

                    'status' =>
                        $userSubscription->status,

                ]

            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' =>
                    'Gagal mengaktifkan subscription.',

                'error' =>
                    $e->getMessage(),

            ], 500);

        }
    }

    /**
     * Reject pembayaran
     */
    public function reject(
        Request $request,
        $uuid
    ) {

        $request->validate([
            'rejected_reason' => 'required|string|max:1000'
        ], [
            'rejected_reason.required' =>
                'Alasan penolakan wajib diisi.'
        ]);


        $payment = UserOrderManual::where(
            'uuid',
            $uuid
        )->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Jangan proses jika expired
        |--------------------------------------------------------------------------
        */

        if (
            $payment->expired_at &&
            Carbon::parse($payment->expired_at)->isPast()
        ) {

            return response()->json([
                'message' => 'Pembayaran sudah expired dan tidak dapat diproses.'
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Hanya pending yang dapat di-reject
        |--------------------------------------------------------------------------
        */

        if ($payment->status !== 'verification') {

            return response()->json([
                'message' => 'Pembayaran sudah diproses sebelumnya.'
            ], 422);

        }


        DB::beginTransaction();

        try {

            $payment->status = 'rejected';

            $payment->rejected_reason =
                $request->rejected_reason;

            $payment->verified_by = Auth::id();

            $payment->verified_at = now();

            $payment->save();


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil ditolak.'
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menolak pembayaran.'
            ], 500);
        }
    }

    public function show($uuid)
    {
        $payment = UserOrderManual::with([
            'user',
            'subscription'
        ])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }
}