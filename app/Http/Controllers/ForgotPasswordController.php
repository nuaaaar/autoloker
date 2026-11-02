<?php

namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        try {
            SendPasswordResetLink::dispatch($request->input('email'));
        } catch (Throwable $exception) {
            Log::error('Password reset enqueue failed', ['exception' => $exception::class]);

            return back()->with([
                'forgot_error' => 'Permintaan reset kata sandi belum dapat diproses. Silakan coba kembali nanti.',
                'show_forgot_modal' => true,
            ]);
        }

        return back()->with([
            'forgot_success' => 'Jika alamat email terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.',
            'show_forgot_modal' => true,
        ]);
    }
}