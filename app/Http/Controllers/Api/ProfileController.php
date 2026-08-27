<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileRequest;
use App\Services\Api\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profiles) {}

    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['profile' => $this->profiles->show($request->user())],
        ]);
    }

    public function update(ProfileRequest $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.',
            'data' => ['profile' => $this->profiles->update($request->user(), $request->validated())],
        ]);
    }
}
