<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\JobApplicationIndexRequest;
use App\Http\Resources\Api\JobVacancyResource;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JobApplicationController extends Controller
{
    private const PER_PAGE = 5;

    public function index(JobApplicationIndexRequest $request): JsonResponse
    {
        $security = $this->security($request);

        $applications = JobApplication::query()
            ->with([
                'job_vacancy' => function ($query): void {
                    $query->with([
                        'bujp:id,company_name',
                        'company:id,company_name',
                    ]);
                },
            ])
            ->where('security_id', $security->id)
            ->whereHas('job_vacancy')
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $vacancies = collect($applications->items())
            ->map(function (JobApplication $application): ?JobVacancy {
                $vacancy = $application->job_vacancy;

                if (! $vacancy) {
                    return null;
                }

                $vacancy->setAttribute('application_uuid', $application->uuid);
                $vacancy->setAttribute('application_status', $application->status);
                $vacancy->setAttribute('applied_at', $application->created_at);
                $vacancy->setAttribute('application_updated_at', $application->updated_at);

                return $vacancy;
            })
            ->filter()
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => [
                'job_vacancies' => JobVacancyResource::collection($vacancies)->resolve(),
                'pagination' => $this->pagination($applications),
            ],
        ]);
    }

    public function store(Request $request, string $uuid): JsonResponse
    {
        $security = $this->security($request);
        $vacancy = JobVacancy::query()
            ->where('uuid', $uuid)
            ->where('status', 'published')
            ->firstOrFail();

        $result = DB::transaction(function () use ($security, $vacancy): array {
            $vacancy = JobVacancy::query()
                ->lockForUpdate()
                ->findOrFail($vacancy->id);

            if ($vacancy->status !== 'published') {
                return [
                    'error' => 'Lowongan kerja ini tidak tersedia untuk dilamar.',
                    'status' => 404,
                ];
            }

            if ($vacancy->end_date && now()->startOfDay()->gt($vacancy->end_date)) {
                return [
                    'error' => 'Masa lamaran lowongan kerja ini telah berakhir.',
                    'status' => 422,
                ];
            }

            $application = JobApplication::query()
                ->where('security_id', $security->id)
                ->where('job_vacancy_id', $vacancy->id)
                ->first();

            if ($application) {
                return [
                    'error' => 'Anda sudah melamar lowongan kerja ini.',
                    'status' => 422,
                ];
            }

            if ($vacancy->kuota) {
                $applicantCount = JobApplication::query()
                    ->where('job_vacancy_id', $vacancy->id)
                    ->count();

                if ($applicantCount >= $vacancy->kuota) {
                    return [
                        'error' => "Kuota lowongan penuh ({$applicantCount}/{$vacancy->kuota} lamaran). Lamaran baru tidak dapat dikirim.",
                        'status' => 422,
                    ];
                }
            }

            return [
                'application' => JobApplication::create([
                    'security_id' => $security->id,
                    'job_vacancy_id' => $vacancy->id,
                ]),
            ];
        });

        if (isset($result['error'])) {
            return response()->json([
                'status' => false,
                'message' => $result['error'],
            ], $result['status']);
        }

        /** @var JobApplication $application */
        $application = $result['application'];

        return response()->json([
            'status' => true,
            'message' => 'Lamaran kerja berhasil dikirim.',
            'data' => [
                'job_application' => [
                    'id' => $application->id,
                    'uuid' => $application->uuid,
                    'job_vacancy_id' => $application->job_vacancy_id,
                    'status' => $application->status,
                    'created_at' => $application->created_at,
                ],
            ],
        ], 201);
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $application = JobApplication::query()
            ->where('uuid', $uuid)
            ->where('security_id', $this->security($request)->id)
            ->firstOrFail();

        $application->delete();

        return response()->json([
            'status' => true,
            'message' => 'Lamaran kerja berhasil dibatalkan.',
        ]);
    }

    private function security(Request $request)
    {
        if ($request->user()?->role !== 'satpam') {
            throw new NotFoundHttpException('Profil satpam tidak ditemukan.');
        }

        $security = $request->user()->user_security?->security;

        if (! $security) {
            throw new NotFoundHttpException('Profil satpam tidak ditemukan.');
        }

        return $security;
    }

    private function pagination($paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'has_more' => $paginator->hasMorePages(),
            'next_page_url' => $paginator->nextPageUrl(),
            'previous_page_url' => $paginator->previousPageUrl(),
        ];
    }
}
