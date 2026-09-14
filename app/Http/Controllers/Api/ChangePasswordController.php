<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Services\Api\AuthenticationService;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    public function __construct(private readonly AuthenticationService $authentication) {}

    public function __invoke(ChangePasswordRequest $request): JsonResponse
    {
        $this->authentication->changePassword($request->user(), $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}
