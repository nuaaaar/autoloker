<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedJobVacancyIndexRequest;
use App\Http\Requests\Api\OwnedJobVacancyStoreRequest;
use App\Http\Requests\Api\OwnedJobVacancySubmitRequest;
use App\Http\Requests\Api\OwnedJobVacancyUpdateRequest;
use App\Http\Resources\Api\JobVacancyResource;
use App\Http\Resources\Api\OwnedJobVacancyResource;
use App\Models\JobVacancy;
use App\Services\Api\JobVacancyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OwnedJobVacancyController extends OwnedOrganizationController
{
    private const PER_PAGE = 5;

    /**
     * List vacancies created by the authenticated company or BUJP.
     */
    public function index(OwnedJobVacancyIndexRequest $request): JsonResponse
    {
        $owner = $this->owner($request);
        $filters = $request->validated();

        $query = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->withCount('applications as total_applications')
            ->where($owner['column'], $owner['id']);

        if (($status = $filters['status'] ?? null) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];

            $query->where(function (Builder $query) use ($search): void {
                $query->where('position', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('village', 'like', "%{$search}%");
            });
        }

        $vacancies = $query
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'data' => [
                'job_vacancies' => JobVacancyResource::collection($vacancies->items())->resolve(),
                'pagination' => $this->pagination($vacancies),
            ],
        ]);
    }

    public function store(
        OwnedJobVacancyStoreRequest $request,
        JobVacancyService $service,
    ): JsonResponse {
        $owner = $this->owner($request);
        $this->ensureBujp($request);
        $vacancy = $service->create($owner['id'], $request->validated());

        return $this->mutationResponse(
            $vacancy,
            'Job vacancy created successfully.',
            201,
            true,
        );
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        $vacancy = $this->ownedBujpVacancy($request, $uuid);

        return response()->json([
            'status' => true,
            'message' => 'Job vacancy retrieved successfully.',
            'data' => [
                'job_vacancy' => $this->resourceData($vacancy),
            ],
        ]);
    }

    public function update(
        OwnedJobVacancyUpdateRequest $request,
        JobVacancyService $service,
        string $uuid,
    ): JsonResponse {
        $vacancy = $this->ownedBujpVacancy($request, $uuid);
        $vacancy = $service->update($vacancy, $request->validated());

        return $this->mutationResponse(
            $vacancy,
            'Job vacancy updated successfully.',
        );
    }

    public function submit(
        OwnedJobVacancySubmitRequest $request,
        JobVacancyService $service,
        string $uuid,
    ): JsonResponse {
        $vacancy = $this->ownedBujpVacancy($request, $uuid);
        $vacancy = $service->submit($vacancy);

        return $this->mutationResponse(
            $vacancy,
            'Job vacancy submitted for review successfully.',
        );
    }

    private function ownedBujpVacancy(Request $request, string $uuid): JobVacancy
    {
        $owner = $this->owner($request);
        $this->ensureBujp($request);

        return JobVacancy::query()
            ->where('uuid', $uuid)
            ->where('b_u_j_p_id', $owner['id'])
            ->firstOrFail();
    }

    private function ensureBujp(Request $request): void
    {
        if ($request->user()?->role !== 'bujp') {
            throw new NotFoundHttpException('BUJP profile not found.');
        }
    }

    private function mutationResponse(
        JobVacancy $vacancy,
        string $message,
        int $status = 200,
        bool $includeLocation = false,
    ): JsonResponse {
        $response = response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'job_vacancy' => $this->resourceData($vacancy),
            ],
        ], $status);

        if ($includeLocation) {
            $response->header(
                'Location',
                route('api.company.job-vacancies.show', ['uuid' => $vacancy->uuid]),
            );
        }

        return $response;
    }

    private function resourceData(JobVacancy $vacancy): array
    {
        $vacancy->load('bujp:id,uuid,company_name')
            ->loadCount('applications as total_applications');

        return (new OwnedJobVacancyResource($vacancy))->resolve();
    }
}
