<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TrainingApplicationIndexRequest;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use App\Models\TrainingApplication;
use App\Services\Api\ApplicantProfileResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainingApplicationController extends Controller
{
    private const PER_PAGE = 5;

    public function __construct(private readonly ApplicantProfileResolver $applicants) {}

    public function index(TrainingApplicationIndexRequest $request): JsonResponse
    {
        $applicant = $this->applicants->resolve($request->user());

        $applications = TrainingApplication::query()
            ->with([
                'training' => function ($query): void {
                    $query
                        ->with([
                            'bujp:id,company_name',
                            'company:id,company_name',
                        ])
                        ->withCount([
                            'applications as approved_applications_count' => function ($query): void {
                                $query->where('status', 'approved');
                            },
                        ]);
                },
            ])
            ->where($applicant['column'], $applicant['profile_id'])
            ->whereHas('training')
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $trainings = collect($applications->items())
            ->map(function (TrainingApplication $application): ?Training {
                $training = $application->training;

                if (! $training) {
                    return null;
                }

                $training->setAttribute('application_uuid', $application->uuid);
                $training->setAttribute('application_status', $application->status);
                $training->setAttribute('applied_at', $application->created_at);
                $training->setAttribute('application_updated_at', $application->updated_at);

                return $training;
            })
            ->filter()
            ->values()
            ->all();

        return response()->json([
            'status' => true,
            'data' => [
                'trainings' => TrainingResource::collection($trainings)->resolve(),
                'pagination' => $this->pagination($applications),
            ],
        ]);
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $applicant = $this->applicants->resolve($request->user());

        $application = TrainingApplication::query()
            ->where('uuid', $uuid)
            ->where($applicant['column'], $applicant['profile_id'])
            ->firstOrFail();

        $application->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pendaftaran pelatihan berhasil dibatalkan.',
        ]);
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
