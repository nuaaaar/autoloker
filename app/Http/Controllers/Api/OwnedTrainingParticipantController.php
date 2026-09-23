<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedTrainingParticipantIndexRequest;
use App\Http\Resources\Api\TrainingParticipantResource;
use App\Models\Training;
use App\Models\TrainingApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OwnedTrainingParticipantController extends OwnedOrganizationController
{
    private const PER_PAGE = 5;

    /**
     * List participants for a training owned by the authenticated BUJP.
     */
    public function index(OwnedTrainingParticipantIndexRequest $request, string $uuid): JsonResponse
    {
        if ($request->user()?->role !== 'bujp') {
            throw new NotFoundHttpException('BUJP profile not found.');
        }

        $owner = $this->owner($request);
        $training = Training::query()
            ->where('uuid', $uuid)
            ->where($owner['column'], $owner['id'])
            ->firstOrFail();

        $filters = $request->validated();
        $query = TrainingApplication::query()
            ->with('security')
            ->where('training_id', $training->id);

        if (($status = $filters['status'] ?? null) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (filled($filters['search'] ?? null)) {
            $search = trim($filters['search']);

            $query->whereHas('security', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%")
                        ->orWhere('ktp_number', 'like', "%{$search}%")
                        ->orWhere('registration_number', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query
            ->latest('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'data' => [
                'participants' => TrainingParticipantResource::collection($applications->items())->resolve(),
                'pagination' => $this->pagination($applications),
            ],
        ]);
    }
}
