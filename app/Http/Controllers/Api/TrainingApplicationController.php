<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TrainingApplicationIndexRequest;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use App\Models\TrainingApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingApplicationController extends Controller
{
    private const PER_PAGE = 5;

    public function index(TrainingApplicationIndexRequest $request): JsonResponse
    {
        $security = $this->security($request);

        $applications = TrainingApplication::query()
            ->with([
                'training' => function (Builder $query): void {
                    $query
                        ->with([
                            'bujp:id,company_name',
                            'company:id,company_name',
                        ])
                        ->withCount([
                            'applications as approved_applications_count' => function (Builder $query): void {
                                $query->where('status', 'approved');
                            },
                        ]);
                },
            ])
            ->where('security_id', $security->id)
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

    private function security(Request $request)
    {
        if ($request->user()?->role !== 'satpam') {
            throw new NotFoundHttpException('Security profile not found.');
        }

        $security = $request->user()->user_security?->security;

        if (! $security) {
            throw new NotFoundHttpException('Security profile not found.');
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
