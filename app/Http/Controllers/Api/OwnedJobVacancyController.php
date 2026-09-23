<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedJobVacancyIndexRequest;
use App\Http\Resources\Api\JobVacancyResource;
use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
}
