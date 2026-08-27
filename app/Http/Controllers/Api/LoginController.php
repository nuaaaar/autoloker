<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Services\Api\AuthenticationService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private readonly AuthenticationService $authentication) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $result = $this->authentication->login($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Login successful.',
            'data' => array_merge($result['tokens'], ['user' => $result['user']]),
        ]);
    }
}
