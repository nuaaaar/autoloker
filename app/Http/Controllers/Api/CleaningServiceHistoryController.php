<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CleaningServiceHistoryRequest;
use App\Models\CleaningService;
use App\Models\CleaningServiceHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CleaningServiceHistoryController extends Controller
{
    private const FIELDS = [
        'uuid', 'position', 'company_name', 'location', 'category',
        'start_date', 'end_date', 'description', 'is_current',
    ];

    public function index(Request $request): JsonResponse
    {
        $cleaningService = $this->cleaningService($request);

        $histories = $cleaningService->histories()
            ->orderByDesc('start_date')
            ->get(self::FIELDS)
            ->map(fn (CleaningServiceHistory $history) => $this->historyData($history))
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['cleaning_service_histories' => $histories],
        ]);
    }

    public function indexByCleaningService(string $uuid): JsonResponse
    {
        $cleaningService = CleaningService::query()->where('uuid', $uuid)->firstOrFail();

        $histories = $cleaningService->histories()
            ->orderByDesc('start_date')
            ->get(self::FIELDS)
            ->map(fn (CleaningServiceHistory $history) => $this->historyData($history))
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['cleaning_service_histories' => $histories],
        ]);
    }

    public function store(CleaningServiceHistoryRequest $request): JsonResponse
    {
        $cleaningService = $this->cleaningService($request);
        $data = $request->validated();
        $this->validateHistoryState($data);
        $history = $cleaningService->histories()->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Riwayat cleaning service berhasil dibuat.',
            'data' => ['cleaning_service_history' => $this->historyData($history)],
        ], 201);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['cleaning_service_history' => $this->historyData($this->history($request, $uuid))],
        ]);
    }

    public function update(CleaningServiceHistoryRequest $request, string $uuid): JsonResponse
    {
        $history = $this->history($request, $uuid);
        $data = $request->validated();
        $this->validateHistoryState($data, $history);
        $history->update($data);
        $history = $history->fresh();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat cleaning service berhasil diperbarui.',
            'data' => ['cleaning_service_history' => $this->historyData($history)],
        ]);
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $this->history($request, $uuid)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat cleaning service berhasil dihapus.',
        ]);
    }

    private function historyData(CleaningServiceHistory $history): array
    {
        $data = $history->only(self::FIELDS);
        $data['is_current'] = (bool) $history->is_current;

        return $data;
    }

    private function validateHistoryState(array $data, ?CleaningServiceHistory $existing = null): void
    {
        $isCurrent = array_key_exists('is_current', $data)
            ? filter_var($data['is_current'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            : (bool) ($existing?->is_current ?? false);
        $endDate = array_key_exists('end_date', $data)
            ? $data['end_date']
            : $existing?->end_date;

        if ($endDate === null && $isCurrent !== true) {
            throw ValidationException::withMessages([
                'end_date' => 'Tanggal akhir hanya boleh dikosongkan jika riwayat ini masih berlaku.',
            ]);
        }
    }

    private function cleaningService(Request $request)
    {
        if ($request->user()?->role !== 'cs') {
            throw new NotFoundHttpException('Profil cleaning service tidak ditemukan.');
        }

        $cleaningService = $request->user()->user_cleaning_service?->cleaning_service;

        if (! $cleaningService) {
            throw new NotFoundHttpException('Profil cleaning service tidak ditemukan.');
        }

        return $cleaningService;
    }

    private function history(Request $request, string $uuid): CleaningServiceHistory
    {
        return $this->cleaningService($request)->histories()->where('uuid', $uuid)->firstOrFail();
    }
}
