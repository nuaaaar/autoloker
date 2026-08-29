<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SecurityHistoryRequest;
use App\Models\SecurityHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SecurityHistoryController extends Controller
{
    private const FIELDS = [
        'uuid', 'position', 'company_name', 'location', 'category',
        'start_date', 'end_date', 'description', 'is_current',
    ];

    public function index(Request $request): JsonResponse
    {
        $security = $this->security($request);

        return response()->json([
            'status' => true,
            'data' => ['security_histories' => $security->histories()->latest()->get(self::FIELDS)],
        ]);
    }

    public function store(SecurityHistoryRequest $request): JsonResponse
    {
        $security = $this->security($request);
        $history = $security->histories()->create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Security history created successfully.',
            'data' => ['security_history' => $history->only(self::FIELDS)],
        ], 201);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['security_history' => $this->history($request, $uuid)->only(self::FIELDS)],
        ]);
    }

    public function update(SecurityHistoryRequest $request, string $uuid): JsonResponse
    {
        $history = $this->history($request, $uuid);
        $history->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Security history updated successfully.',
            'data' => ['security_history' => $history->fresh()->only(self::FIELDS)],
        ]);
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $this->history($request, $uuid)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Security history deleted successfully.',
        ]);
    }

    private function security(Request $request)
    {
        if ($request->user()?->role !== 'satpam') {
            throw new NotFoundHttpException('Security profile not found.');
        }

        $security = $request->user()->user_security?->security;
        if (!$security) {
            throw new NotFoundHttpException('Security profile not found.');
        }

        return $security;
    }

    private function history(Request $request, string $uuid): SecurityHistory
    {
        return $this->security($request)->histories()->where('uuid', $uuid)->firstOrFail();
    }
}
