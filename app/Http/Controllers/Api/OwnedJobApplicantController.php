<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedJobApplicantIndexRequest;
use App\Http\Resources\Api\JobApplicantResource;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class OwnedJobApplicantController extends OwnedOrganizationController
{
    private const PER_PAGE = 5;

    /**
     * List applicants for a vacancy owned by the authenticated company or BUJP.
     */
    public function index(OwnedJobApplicantIndexRequest $request, string $uuid): JsonResponse
    {
        $owner = $this->owner($request);
        $vacancy = JobVacancy::query()
            ->where('uuid', $uuid)
            ->where($owner['column'], $owner['id'])
            ->firstOrFail();

        $filters = $request->validated();
        $query = JobApplication::query()
            ->with('security')
            ->where('job_vacancy_id', $vacancy->id);

        if (($status = $filters['status'] ?? null) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (filled($filters['search'] ?? null)) {
            $search = trim($filters['search']);

            $query->whereHas('security', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%")
                        ->orWhere('ktp_number', 'like', "%{$search}%")
                        ->orWhere('registration_number', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'data' => [
                'applicants' => JobApplicantResource::collection($applications->items())->resolve(),
                'pagination' => $this->pagination($applications),
            ],
        ]);
    }
}
