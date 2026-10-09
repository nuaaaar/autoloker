<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangeRoleRequest;
use App\Services\Api\AuthenticationService;
use App\Services\Api\RoleSwitchService;
use Illuminate\Http\JsonResponse;

class ChangeRoleController extends Controller
{
    public function __construct(
        private readonly RoleSwitchService $roles,
        private readonly AuthenticationService $auth,
    ) {}

    public function __invoke(ChangeRoleRequest $request): JsonResponse
    {
        $this->roles->switch($request->user(), $request->validated('role'));

        return response()->json([
            'status' => true,
            'message' => 'Role akun berhasil diganti.',
            'data' => [
                'me' => $this->auth->userData($request->user()->fresh()),
            ],
        ]);
    }
}
