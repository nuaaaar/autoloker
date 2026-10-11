<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\JobVacancyIndexRequest;
use App\Http\Resources\Api\JobVacancyResource;
use App\Models\JobVacancy;
use App\Services\Api\ApplicantProfileResolver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class JobVacancyController extends Controller
{
    private const PER_PAGE = 5;

    public function __construct(private readonly ApplicantProfileResolver $applicants) {}

    /**
     * List published, non-expired vacancies for the active applicant category.
     */
    public function index(JobVacancyIndexRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $applicant = $this->applicants->resolve($request->user());
        $category = $applicant['category'];
        $column = $applicant['column'];
        $profileId = $applicant['profile_id'];

        $query = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->withCount('applications as total_applications')
            ->withExists([
                'applications as is_applied' => function (Builder $query) use ($column, $profileId): void {
                    $query->whereNotNull($column)
                        ->where($column, $profileId);
                },
            ])
            ->where('category', $category)
            ->where('status', 'published')
            ->where(function (Builder $query): void {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now()->toDateString());
            });
        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];

            $query->where(function (Builder $query) use ($search): void {
                $query->where('position', 'like', "%{$search}%")
                    ->orWhereHas('company', function (Builder $query) use ($search): void {
                        $query->where('company_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('bujp', function (Builder $query) use ($search): void {
                        $query->where('company_name', 'like', "%{$search}%");
                    });
            });
        }

        if (filled($filters['province_name'] ?? null)) {
            $query->where('province', $filters['province_name']);
        }

        if (filled($filters['working_type'] ?? null)) {
            $query->where('working_type', $filters['working_type']);
        }

        if (filled($filters['working_system'] ?? null)) {
            $query->where('working_system', $filters['working_system']);
        }

        if (filled($filters['certificate'] ?? null)) {
            $query->whereJsonContains('certificate', $filters['certificate']);
        }

        if (array_key_exists('min_price', $filters) && $filters['min_price'] !== null) {
            $this->applyMinimumPriceFilter($query, (float) $filters['min_price']);
        }

        if (array_key_exists('is_urgent', $filters) && $filters['is_urgent'] !== null) {
            $query->where('is_urgent', $filters['is_urgent']);
        }

        if (array_key_exists('min_experience', $filters) && $filters['min_experience'] !== null) {
            $this->applyMinimumExperienceFilter($query, (int) $filters['min_experience']);
        }

        if (filled($filters['gender'] ?? null)) {
            $query->where(function (Builder $query) use ($filters): void {
                $query->whereNull('gender')
                    ->orWhere('gender', $filters['gender']);
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
                'pagination' => [
                    'current_page' => $vacancies->currentPage(),
                    'last_page' => $vacancies->lastPage(),
                    'per_page' => $vacancies->perPage(),
                    'total' => $vacancies->total(),
                    'from' => $vacancies->firstItem(),
                    'to' => $vacancies->lastItem(),
                    'has_more' => $vacancies->hasMorePages(),
                    'next_page_url' => $vacancies->nextPageUrl(),
                    'previous_page_url' => $vacancies->previousPageUrl(),
                ],
            ],
        ]);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();
        $application = null;
        $query = JobVacancy::query()->where('uuid', $uuid);

        if ($user->role === 'company') {
            $companyId = $user->user_company?->company?->id;
            $query->where('company_id', $companyId ?? 0);
        } else {
            $securityId = $user->user_security?->security?->id;
            $cleaningServiceId = $user->user_cleaning_service?->cleaning_service?->id;
            $query->whereHas('applications', function (Builder $applications) use ($securityId, $cleaningServiceId): void {
                if ($securityId === null && $cleaningServiceId === null) {
                    $applications->whereRaw('1 = 0');
                    return;
                }
                $applications->where(function (Builder $profiles) use ($securityId, $cleaningServiceId): void {
                    if ($securityId !== null) {
                        $profiles->where('security_id', $securityId);
                    }
                    if ($cleaningServiceId !== null) {
                        $method = $securityId !== null ? 'orWhere' : 'where';
                        $profiles->{$method}('cleaning_service_id', $cleaningServiceId);
                    }
                });
            });
        }

        $vacancy = $query->with(['bujp:id,company_name', 'company:id,company_name'])->firstOrFail();

        if ($user->role !== 'company') {
            $application = $vacancy->applications()
                ->where(function (Builder $profiles) use ($user): void {
                    $securityId = $user->user_security?->security?->id;
                    $cleaningServiceId = $user->user_cleaning_service?->cleaning_service?->id;
                    if ($securityId !== null) {
                        $profiles->where('security_id', $securityId);
                    }
                    if ($cleaningServiceId !== null) {
                        $method = $securityId !== null ? 'orWhere' : 'where';
                        $profiles->{$method}('cleaning_service_id', $cleaningServiceId);
                    }
                })
                ->firstOrFail();
            $vacancy->setAttribute('is_applied', true);
            $vacancy->setAttribute('application_uuid', $application->uuid);
            $vacancy->setAttribute('application_status', $application->status);
            $vacancy->setAttribute('applied_at', $application->created_at);
            $vacancy->setAttribute('application_updated_at', $application->updated_at);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lowongan kerja berhasil diambil.',
            'data' => ['job_vacancy' => (new JobVacancyResource($vacancy))->resolve()],
        ]);
    }

    private function applyMinimumPriceFilter(Builder $query, float $minimumPrice): void
    {
        $castType = $query->getModel()->getConnection()->getDriverName() === 'mysql'
            ? 'DECIMAL(20, 2)'
            : 'NUMERIC';

        $query->whereNotNull('min_price')
            ->where('min_price', '<>', '')
            ->whereRaw("CAST(min_price AS {$castType}) >= ?", [$minimumPrice]);
    }

    private function applyMinimumExperienceFilter(Builder $query, int $minimumExperience): void
    {
        $query->where(function (Builder $query) use ($minimumExperience): void {
            $query->whereNull('min_experience')
                ->orWhere('min_experience', '');

            if ($query->getModel()->getConnection()->getDriverName() === 'mysql') {
                $query->orWhereRaw(
                    "CAST(REGEXP_SUBSTR(min_experience, '[0-9]+') AS UNSIGNED) <= ?",
                    [$minimumExperience]
                );

                return;
            }

            $query->orWhereRaw(
                'CAST(min_experience AS INTEGER) <= ?',
                [$minimumExperience]
            );
        });
    }
}
