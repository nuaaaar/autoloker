<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GoogleAuthRequest;
use App\Services\Api\GoogleAuthenticationService;
use Illuminate\Http\JsonResponse;

class GoogleAuthController extends Controller
{
    public function __construct(private readonly GoogleAuthenticationService $authentication) {}

    public function login(GoogleAuthRequest $request): JsonResponse
    {
        $result = $this->authentication->login($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil.',
            'data' => array_merge($result['tokens'], ['user' => $result['user']]),
        ]);
    }

    public function register(GoogleAuthRequest $request): JsonResponse
    {
        $result = $this->authentication->register($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Pendaftaran berhasil.',
            'data' => array_merge($result['tokens'], ['user' => $result['user']]),
        ], 201);
    }
}
