<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedTrainingIndexRequest;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
}
