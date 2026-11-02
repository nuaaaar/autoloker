<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Jobs\SendPasswordResetLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            SendPasswordResetLink::dispatch($request->validated('email'));
        } catch (Throwable $exception) {
            Log::error('Password reset enqueue failed', ['exception' => $exception::class]);

            return response()->json([
                'status' => false,
                'message' => 'Permintaan reset kata sandi belum dapat diproses. Silakan coba kembali nanti.',
            ], 503);
        }

        return response()->json([
            'status' => true,
            'message' => 'Jika alamat email terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.',
        ], 202);
    }
}
