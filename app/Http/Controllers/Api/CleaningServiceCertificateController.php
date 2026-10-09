<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CleaningServiceCertificateRequest;
use App\Models\CleaningService;
use App\Models\CleaningServiceCertificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CleaningServiceCertificateController extends Controller
{
    private const FIELDS = [
        'uuid', 'title', 'publisher', 'certificate_number', 'category',
        'publish_date', 'expired_date', 'file', 'is_badge',
    ];

    public function index(Request $request): JsonResponse
    {
        $cleaningService = $this->cleaningService($request);

        $certificates = $cleaningService->certificates()
            ->orderBy('expired_date', 'asc')
            ->get(self::FIELDS)
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['cleaning_service_certificates' => $certificates],
        ]);
    }

    public function indexByCleaningService(string $uuid): JsonResponse
    {
        $cleaningService = CleaningService::query()->where('uuid', $uuid)->firstOrFail();

        $certificates = $cleaningService->certificates()
            ->orderBy('expired_date', 'asc')
            ->get(self::FIELDS)
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['cleaning_service_certificates' => $certificates],
        ]);
    }

    public function store(CleaningServiceCertificateRequest $request): JsonResponse
    {
        $cleaningService = $this->cleaningService($request);
        $data = $request->validated();
        $this->storeFile($request, $data);
        $certificate = $cleaningService->certificates()->create($data);
        $this->setBadge($certificate);

        return response()->json([
            'status' => true,
            'message' => 'Sertifikat cleaning service berhasil dibuat.',
            'data' => ['cleaning_service_certificate' => $certificate->only(self::FIELDS)],
        ], 201);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['cleaning_service_certificate' => $this->certificate($request, $uuid)->only(self::FIELDS)],
        ]);
    }

    public function update(CleaningServiceCertificateRequest $request, string $uuid): JsonResponse
    {
        $certificate = $this->certificate($request, $uuid);
        $data = $request->validated();
        if ($request->hasFile('file')) {
            $this->deleteFile($certificate->file);
            $this->storeFile($request, $data);
        }
        $certificate->update($data);
        $this->setBadge($certificate->fresh());

        return response()->json([
            'status' => true,
            'message' => 'Sertifikat cleaning service berhasil diperbarui.',
            'data' => ['cleaning_service_certificate' => $certificate->fresh()->only(self::FIELDS)],
        ]);
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $certificate = $this->certificate($request, $uuid);
        $this->deleteFile($certificate->file);
        $certificate->delete();

        return response()->json(['status' => true, 'message' => 'Sertifikat cleaning service berhasil dihapus.']);
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

    private function certificate(Request $request, string $uuid): CleaningServiceCertificate
    {
        return $this->cleaningService($request)->certificates()->where('uuid', $uuid)->firstOrFail();
    }

    private function storeFile(Request $request, array &$data): void
    {
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('certificate', 'public');
        }
    }

    private function deleteFile(?string $file): void
    {
        if ($file && Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
        }
    }

    private function setBadge(CleaningServiceCertificate $certificate): void
    {
        if ($certificate->is_badge) {
            CleaningServiceCertificate::where('cleaning_service_id', $certificate->cleaning_service_id)
                ->where('id', '!=', $certificate->id)
                ->update(['is_badge' => 0]);
        }
    }
}
