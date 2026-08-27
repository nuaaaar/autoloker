<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct(private readonly AuthenticationService $authentication) {}

    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['user' => $this->authentication->userData($request->user())],
        ]);
    }
}
