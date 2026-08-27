<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request, TokenService $tokens): JsonResponse
    {
        $tokens->revoke($request->attributes->get('api_token'));
        return response()->json(['status' => true, 'message' => 'Logout successful.']);
    }
}
