<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SecurityCertificateRequest;
use App\Models\SecurityCertificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SecurityCertificateController extends Controller
{
    private const FIELDS = [
        'uuid', 'title', 'publisher', 'certificate_number', 'category',
        'publish_date', 'expired_date', 'file', 'is_badge',
    ];

    public function index(Request $request): JsonResponse
    {
        $security = $this->security($request);

        $certificates = $security->certificates()
            ->orderBy('expired_date', 'asc')
            ->get(self::FIELDS)
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => ['security_certificates' => $certificates],
        ]);
    }

    public function store(SecurityCertificateRequest $request): JsonResponse
    {
        $security = $this->security($request);
        $data = $request->validated();
        $this->storeFile($request, $data);
        $certificate = $security->certificates()->create($data);
        $this->setBadge($certificate);

        return response()->json([
            'status' => true,
            'message' => 'Security certificate created successfully.',
            'data' => ['security_certificate' => $certificate->only(self::FIELDS)],
        ], 201);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => ['security_certificate' => $this->certificate($request, $uuid)->only(self::FIELDS)],
        ]);
    }

    public function update(SecurityCertificateRequest $request, string $uuid): JsonResponse
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
            'message' => 'Security certificate updated successfully.',
            'data' => ['security_certificate' => $certificate->fresh()->only(self::FIELDS)],
        ]);
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $certificate = $this->certificate($request, $uuid);
        $this->deleteFile($certificate->file);
        $certificate->delete();

        return response()->json(['status' => true, 'message' => 'Security certificate deleted successfully.']);
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

    private function certificate(Request $request, string $uuid): SecurityCertificate
    {
        return $this->security($request)->certificates()->where('uuid', $uuid)->firstOrFail();
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

    private function setBadge(SecurityCertificate $certificate): void
    {
        if ($certificate->is_badge) {
            SecurityCertificate::where('security_id', $certificate->security_id)
                ->where('id', '!=', $certificate->id)
                ->update(['is_badge' => 0]);
        }
    }
}
