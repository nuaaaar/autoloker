<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\JobVacancyIndexRequest;
use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class JobVacancyController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * List published, non-expired vacancies for mobile infinite scrolling.
     */
    public function index(JobVacancyIndexRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $query = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->where('status', 'published')
            ->where(function (Builder $query): void {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now()->toDateString());
            });

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
                'job_vacancies' => $vacancies->items(),
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
