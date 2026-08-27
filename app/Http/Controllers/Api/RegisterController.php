<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\Api\RegistrationService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrationService,
    ) {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = $this->registrationService->register($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Registration successful.',
            'data' => [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'role' => $user->role,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }
}
