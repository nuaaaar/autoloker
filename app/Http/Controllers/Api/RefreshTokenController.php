<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RefreshTokenRequest;
use App\Services\Api\TokenService;
use Illuminate\Http\JsonResponse;

class RefreshTokenController extends Controller
{
    public function __construct(private readonly TokenService $tokens) {}

    public function __invoke(RefreshTokenRequest $request): JsonResponse
    {
        try {
            $tokens = $this->tokens->refresh($request->validated('refresh_token'));
        } catch (\InvalidArgumentException) {
            return response()->json(['status' => false, 'message' => 'Invalid refresh token.'], 401);
        }

        return response()->json(['status' => true, 'data' => $tokens]);
    }
}
