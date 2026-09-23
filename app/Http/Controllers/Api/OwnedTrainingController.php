<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedTrainingIndexRequest;
use App\Http\Requests\Api\OwnedTrainingStoreRequest;
use App\Http\Requests\Api\OwnedTrainingSubmitRequest;
use App\Http\Requests\Api\OwnedTrainingUpdateRequest;
use App\Http\Resources\Api\OwnedTrainingResource;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use App\Services\Api\TrainingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OwnedTrainingController extends OwnedOrganizationController
{
    private const PER_PAGE = 5;

    /**
     * List trainings created by the authenticated company or BUJP.
     */
    public function index(OwnedTrainingIndexRequest $request): JsonResponse
    {
        $owner = $this->owner($request);
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
            ->where($owner['column'], $owner['id']);

        if (($status = $filters['status'] ?? null) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];

            $query->where(function (Builder $query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('provider', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('level', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('village', 'like', "%{$search}%");
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
                'pagination' => $this->pagination($trainings),
            ],
        ]);
    }

    public function store(
        OwnedTrainingStoreRequest $request,
        TrainingService $service,
    ): JsonResponse {
        $owner = $this->owner($request);
        $this->ensureBujp($request);
        $training = $service->create($owner['id'], $request->validated());

        return $this->mutationResponse(
            $training,
            'Training created successfully.',
            201,
            true,
        );
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        $training = $this->ownedBujpTraining($request, $uuid);

        return response()->json([
            'status' => true,
            'message' => 'Training retrieved successfully.',
            'data' => [
                'training' => $this->resourceData($training),
            ],
        ]);
    }

    public function update(
        OwnedTrainingUpdateRequest $request,
        TrainingService $service,
        string $uuid,
    ): JsonResponse {
        $training = $this->ownedBujpTraining($request, $uuid);
        $training = $service->update($training, $request->validated());

        return $this->mutationResponse(
            $training,
            'Training updated successfully.',
        );
    }

    public function submit(
        OwnedTrainingSubmitRequest $request,
        TrainingService $service,
        string $uuid,
    ): JsonResponse {
        $training = $this->ownedBujpTraining($request, $uuid);
        $training = $service->submit($training);

        return $this->mutationResponse(
            $training,
            'Training submitted for review successfully.',
        );
    }

    private function ownedBujpTraining(Request $request, string $uuid): Training
    {
        $owner = $this->owner($request);
        $this->ensureBujp($request);

        return Training::query()
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
        Training $training,
        string $message,
        int $status = 200,
        bool $includeLocation = false,
    ): JsonResponse {
        $response = response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'training' => $this->resourceData($training),
            ],
        ], $status);

        if ($includeLocation) {
            $response->header(
                'Location',
                route('api.company.trainings.show', ['uuid' => $training->uuid]),
            );
        }

        return $response;
    }

    private function resourceData(Training $training): array
    {
        $training->load([
            'bujp:id,uuid,company_name',
            'company:id,company_name',
        ])
            ->loadCount([
                'applications as registered_count' => function (Builder $query): void {
                    $query->whereIn('status', ['pending', 'approved']);
                },
                'applications as approved_count' => function (Builder $query): void {
                    $query->where('status', 'approved');
                },
            ]);

        return (new OwnedTrainingResource($training))->resolve();
    }
}
