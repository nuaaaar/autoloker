<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DeleteAccountRequest;
use App\Services\Api\AccountDeletionService;
use Illuminate\Http\JsonResponse;

class DeleteAccountController
{
    public function __invoke(DeleteAccountRequest $request, AccountDeletionService $accounts): JsonResponse
    {
        $pending = ! $accounts->delete($request->user());
        return response()->json([
            'status' => true,
            'message' => $pending ? 'Akun telah dihapus. Penghapusan berkas terkait masih diproses.' : 'Akun dan data terkait berhasil dihapus.',
            'data' => ['files_pending' => $pending],
        ], $pending ? 202 : 200);
    }
}
