<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TrainingIndexRequest;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use App\Models\TrainingApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * List published trainings for security mobile apps.
     */
    public function index(TrainingIndexRequest $request): JsonResponse
    {
        if ($request->user()?->role !== 'satpam') {
            throw new NotFoundHttpException('Security profile not found.');
        }

        $filters = $request->validated();

        $query = Training::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->withCount([
                'applications as approved_applications_count' => function (Builder $query): void {
                    $query->where('status', 'approved');
                },
            ])
            ->where('status', 'published');

        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];

            $query->where(function (Builder $query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('provider', 'like', "%{$search}%");
            });
        }


        $trainings = $query
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'data' => [
                'trainings' => TrainingResource::collection($trainings->items())->resolve(),
                'pagination' => [
                    'current_page' => $trainings->currentPage(),
                    'last_page' => $trainings->lastPage(),
                    'per_page' => $trainings->perPage(),
                    'total' => $trainings->total(),
                    'from' => $trainings->firstItem(),
                    'to' => $trainings->lastItem(),
                    'has_more' => $trainings->hasMorePages(),
                    'next_page_url' => $trainings->nextPageUrl(),
                    'previous_page_url' => $trainings->previousPageUrl(),
                ],
            ],
        ]);
    }

    public function store(Request $request, string $uuid): JsonResponse
    {
        $security = $this->security($request);
        $training = Training::query()
            ->where('uuid', $uuid)
            ->where('status', 'published')
            ->firstOrFail();

        $result = DB::transaction(function () use ($security, $training): array {
            $training = Training::query()
                ->lockForUpdate()
                ->findOrFail($training->id);

            if ($training->status !== 'published') {
                return [
                    'error' => 'The training is not available for applications.',
                    'status' => 404,
                ];
            }

            $application = TrainingApplication::query()
                ->where('security_id', $security->id)
                ->where('training_id', $training->id)
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            if ($application) {
                return [
                    'error' => $application->status === 'approved'
                        ? 'You are already registered for this training.'
                        : 'Your training application is awaiting approval.',
                    'status' => 422,
                ];
            }

            if ($training->start_date && now()->startOfDay()->gt($training->start_date)) {
                return [
                    'error' => 'Training registration has closed.',
                    'status' => 422,
                ];
            }

            $quota = is_numeric($training->quota) ? (int) $training->quota : 0;

            if ($quota > 0) {
                $approvedCount = TrainingApplication::query()
                    ->where('training_id', $training->id)
                    ->where('status', 'approved')
                    ->count();

                if ($approvedCount >= $quota) {
                    return [
                        'error' => 'The training quota is full.',
                        'status' => 422,
                    ];
                }
            }

            return [
                'application' => TrainingApplication::create([
                    'security_id' => $security->id,
                    'training_id' => $training->id,
                    'status' => 'pending',
                ]),
            ];
        });

        if (isset($result['error'])) {
            return response()->json([
                'status' => false,
                'message' => $result['error'],
            ], $result['status']);
        }

        /** @var TrainingApplication $application */
        $application = $result['application'];

        return response()->json([
            'status' => true,
            'message' => 'Training application submitted successfully.',
            'data' => [
                'training_application' => [
                    'id' => $application->id,
                    'uuid' => $application->uuid,
                    'training_id' => $application->training_id,
                    'status' => $application->status,
                    'created_at' => $application->created_at,
                ],
            ],
        ], 201);
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
}
