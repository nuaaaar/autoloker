<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TrainingIndexRequest;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
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
            ->where('status', 'published');

        if (filled($filters['search'] ?? null)) {
            $search = $filters['search'];

            $query->where(function (Builder $query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('provider', 'like', "%{$search}%");
            });
        }

        if (filled($filters['title'] ?? null)) {
            $query->where('title', 'like', "%{$filters['title']}%");
        }

        if (filled($filters['provider'] ?? null)) {
            $query->where('provider', 'like', "%{$filters['provider']}%");
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
}
