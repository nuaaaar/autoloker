<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedJobVacancyIndexRequest;
use App\Http\Requests\Api\OwnedJobVacancyStoreRequest;
use App\Http\Requests\Api\OwnedJobVacancySubmitRequest;
use App\Http\Requests\Api\OwnedJobVacancyUpdateRequest;
use App\Http\Resources\Api\JobVacancyResource;
use App\Http\Resources\Api\OwnedJobVacancyResource;
use App\Models\JobVacancy;
use App\Models\MasterCertificate;
use App\Models\MasterCompetencyScheme;
use App\Models\MasterPositionCleaningService;
use App\Models\MasterPositionSecurity;
use App\Services\Api\JobVacancyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $vacancy = $service->create($owner, $request->validated());

        return $this->mutationResponse(
            $vacancy,
            'Lowongan kerja berhasil dibuat.',
            201,
            true,
        );
    }

    /**
     * Category-scoped master data for the vacancy create form.
     */
    public function masterData(Request $request): JsonResponse
    {
        $this->owner($request);

        $category = $this->category($request);

        return response()->json([
            'status' => true,
            'data' => [
                'category' => $category,
                'positions' => $this->positions($category),
                'certificates' => $this->titles(MasterCertificate::query(), $category),
                'competency_schemes' => $this->titles(MasterCompetencyScheme::query(), $category),
            ],
        ]);
    }

    /** @return list<array{id: int, uuid: string|null, title: string|null, description: string|null, responsibility: list<mixed>}> */
    private function positions(string $category): array
    {
        $model = $category === 'cs' ? MasterPositionCleaningService::class : MasterPositionSecurity::class;

        return $model::query()
            ->orderBy('title')
            ->get(['id', 'uuid', 'title', 'description', 'responsibility'])
            ->map(fn ($position): array => [
                'id' => (int) $position->id,
                'uuid' => $position->uuid,
                'title' => $position->title,
                'description' => $position->description,
                'responsibility' => $position->responsibility ?? [],
            ])
            ->values()
            ->all();
    }

    /** @return list<array{id: int, uuid: string|null, title: string|null}> */
    private function titles(Builder $query, string $category): array
    {
        return $query
            ->where('category', $category)
            ->orderBy('title')
            ->get(['id', 'uuid', 'title'])
            ->map(fn ($master): array => [
                'id' => (int) $master->id,
                'uuid' => $master->uuid,
                'title' => $master->title,
            ])
            ->values()
            ->all();
    }

    private function category(Request $request): string
    {
        $category = strtolower(trim((string) $request->query('category')));

        if (! in_array($category, ['security', 'cs'], true)) {
            throw new HttpResponseException(response()->json([
                'status' => false,
                'message' => 'Kategori harus security atau cs.',
                'data' => null,
                'errors' => ['category' => ['Kategori harus security atau cs.']],
            ], 422));
        }

        return $category;
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        $vacancy = $this->ownedVacancy($request, $uuid);

        return response()->json([
            'status' => true,
            'message' => 'Lowongan kerja berhasil diambil.',
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
        $vacancy = $this->ownedVacancy($request, $uuid);
        $vacancy = $service->update($vacancy, $request->validated());

        return $this->mutationResponse(
            $vacancy,
            'Lowongan kerja berhasil diperbarui.',
        );
    }

    public function submit(
        OwnedJobVacancySubmitRequest $request,
        JobVacancyService $service,
        string $uuid,
    ): JsonResponse {
        $vacancy = $this->ownedVacancy($request, $uuid);
        $vacancy = $service->submit($vacancy);

        return $this->mutationResponse(
            $vacancy,
            'Lowongan kerja berhasil diajukan untuk ditinjau.',
        );
    }

    private function ownedVacancy(Request $request, string $uuid): JobVacancy
    {
        $owner = $this->owner($request);

        return JobVacancy::query()
            ->where('uuid', $uuid)
            ->where($owner['column'], $owner['id'])
            ->firstOrFail();
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
        $vacancy->load([
            'bujp:id,uuid,company_name',
            'company:id,uuid,company_name',
        ])->loadCount('applications as total_applications');

        return (new OwnedJobVacancyResource($vacancy))->resolve();
    }
}
