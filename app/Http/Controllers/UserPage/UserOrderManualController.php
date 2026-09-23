<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\MasterSubscription;
use App\Models\UserOrderManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserOrderManualController extends Controller
{
    /**
     * ============================================================
     * STORE ORDER
     * ============================================================
     *
     * Membuat user_order_manual
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ROLE MAPPING
        |--------------------------------------------------------------------------
        */

        $roleMapping = [
            'satpam' => 'security',
            'bujp' => 'bujp',
            'company' => 'company',
        ];

        $userRole = strtolower(trim($user->role));

        $role = $roleMapping[$userRole] ?? null;

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role user tidak valid.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'subscription_uuid' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CARI MASTER SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $subscription = MasterSubscription::query()
            ->where('uuid', $request->subscription_uuid)
            ->where('role', $role)
            ->where('is_active', 1)
            ->first();


        if (!$subscription) {

            return response()->json([
                'success' => false,
                'message' => 'Paket tidak ditemukan.',
            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | PAKET DASAR
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(trim($subscription->slug ?? '')) === 'dasar'
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Paket Dasar merupakan paket gratis.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK PENDING ORDER
        |--------------------------------------------------------------------------
        */

        $pendingOrder = UserOrderManual::query()
            ->where('user_id', $user->id)
            ->where(
                'master_subscription_id',
                $subscription->id
            )
            ->where('status', 'pending_payment')
            ->first();


        if ($pendingOrder) {

            return response()->json([
                'success' => true,
                'message' => 'Anda sudah memiliki order yang menunggu pembayaran.',
                'redirect' => route(
                    'user-page.user-subscription.index'
                ),
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER
        |--------------------------------------------------------------------------
        */

        $order = UserOrderManual::create([

            'uuid' => (string) Str::uuid(),

            'user_id' => $user->id,

            'master_subscription_id' =>
                $subscription->id,

            'role' => $role,

            'order_number' =>
                $this->generateOrderNumber(),

            /*
            |--------------------------------------------------------------------------
            | SNAPSHOT HARGA
            |--------------------------------------------------------------------------
            */

            'price' => $subscription->price,

            'status' => 'pending_payment',

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' =>
                'Paket berhasil dipilih. Silakan lanjutkan pembayaran.',

            'redirect' =>
                route('user-page.user-subscription.index'),
        ]);
    }

    private function generateOrderNumber()
    {
        do {

            $orderNumber =
                'ORD-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(5));

        } while (
            UserOrderManual::where(
                'order_number',
                $orderNumber
            )->exists()
        );

        return $orderNumber;
    }

    public function uploadProof(Request $request, $uuid)
    {
        $user = Auth::user();

        $order = UserOrderManual::query()
            ->where('uuid', $uuid)
            ->where('user_id', $user->id)
            ->whereIn('status', [
                'pending_payment',
                'rejected',
            ])
            ->first();

        if (!$order) {
            return redirect()
                ->route('user-page.user-subscription.index')
                ->with('ERR', 'Order tidak ditemukan atau tidak dapat diubah.');
        }

        $request->validate([
            'payment_method' => 'required|string|max:50',
            'payment_account' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | HAPUS FILE LAMA
            |--------------------------------------------------------------------------
            */

            if ($order->file) {

                $oldFile = public_path(
                    'uploads/payment/' . $order->file
                );

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | UPLOAD FILE BARU
            |--------------------------------------------------------------------------
            */

            $file = $request->file('payment_proof');

            $uploadPath = public_path('uploads/payment');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }


            $filename =
                'payment_' .
                $order->order_number .
                '_' .
                time() .
                '.' .
                $file->getClientOriginalExtension();


            $file->move(
                $uploadPath,
                $filename
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
                    $filename,

                'status' =>
                    'verification',

                // Reset data penolakan
                'rejected_reason' =>
                    null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('user-page.user-subscription.index')
                ->with(
                    'OK',
                    'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.'
                );

        } catch (\Throwable $e) {

            \Log::error(
                'Upload payment proof failed',
                [
                    'user_id' => $user->id,
                    'order_id' => $order->id ?? null,
                    'order_uuid' => $uuid,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );


            return redirect()
                ->route('user-page.user-subscription.index')
                ->with(
                    'ERR',
                    'Gagal mengupload bukti pembayaran. Silakan coba lagi.'
                );
        }
    }
}
