<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Transport\TransportException;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        try {
            $status = Password::broker('users')->sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with([
                    'forgot_success' => 'Link reset password berhasil dikirim ke email Anda. Silakan periksa inbox atau folder spam.',
                    'show_forgot_modal' => true,
                ]);
            }

            if ($status === Password::RESET_THROTTLED) {
                return back()->with([
                    'forgot_error' => 'Anda baru saja meminta link reset password. Silakan tunggu beberapa saat sebelum mencoba kembali.',
                    'show_forgot_modal' => true,
                ]);
            }

            return back()
                ->with([
                    'forgot_error' => 'Email tersebut tidak terdaftar dalam sistem.',
                    'show_forgot_modal' => true,
                ])
                ->withInput($request->only('email'));

        } catch (\Throwable $e) {

            Log::error('Forgot Password Email Error', [
                'email' => $request->email,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->with([
                    'forgot_error' => 'Gagal mengirim email reset password. Silakan coba kembali beberapa saat lagi.',
                    'show_forgot_modal' => true,
                ])
                ->withInput($request->only('email'));
        }
    }
}