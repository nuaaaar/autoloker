<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SecurityHistoryRequest;
use App\Models\Security;
use App\Models\SecurityHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

        $histories = $security->histories()
            ->orderByDesc('start_date')
            ->get(self::FIELDS)
            ->map(fn (SecurityHistory $history) => $this->historyData($history))
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['security_histories' => $histories],
        ]);
    }

    public function indexBySecurity(string $uuid): JsonResponse
    {
        $security = Security::query()->where('uuid', $uuid)->firstOrFail();

        $histories = $security->histories()
            ->orderByDesc('start_date')
            ->get(self::FIELDS)
            ->map(fn (SecurityHistory $history) => $this->historyData($history))
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['security_histories' => $histories],
        ]);
    }

    public function store(SecurityHistoryRequest $request): JsonResponse
    {
        $security = $this->security($request);
        $data = $request->validated();
        $this->validateHistoryState($data);
        $history = $security->histories()->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Security history created successfully.',
            'data' => ['security_history' => $this->historyData($history)],
        ], 201);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['security_history' => $this->historyData($this->history($request, $uuid))],
        ]);
    }

    public function update(SecurityHistoryRequest $request, string $uuid): JsonResponse
    {
        $history = $this->history($request, $uuid);
        $data = $request->validated();
        $this->validateHistoryState($data, $history);
        $history->update($data);
        $history = $history->fresh();

        return response()->json([
            'status' => true,
            'message' => 'Security history updated successfully.',
            'data' => ['security_history' => $this->historyData($history)],
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

    private function historyData(SecurityHistory $history): array
    {
        $data = $history->only(self::FIELDS);
        $data['is_current'] = (bool) $history->is_current;

        return $data;
    }

    private function validateHistoryState(array $data, ?SecurityHistory $existing = null): void
    {
        $isCurrent = array_key_exists('is_current', $data)
            ? filter_var($data['is_current'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            : (bool) ($existing?->is_current ?? false);
        $endDate = array_key_exists('end_date', $data)
            ? $data['end_date']
            : $existing?->end_date;

        if ($endDate === null && $isCurrent !== true) {
            throw ValidationException::withMessages([
                'end_date' => 'The end date may be null only when is_current is true.',
            ]);
        }
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
