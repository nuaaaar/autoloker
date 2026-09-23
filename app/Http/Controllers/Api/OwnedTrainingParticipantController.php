<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\OwnedTrainingParticipantIndexRequest;
use App\Http\Requests\Api\OwnedTrainingParticipantStatusRequest;
use App\Http\Resources\Api\TrainingParticipantResource;
use App\Models\Training;
use App\Models\TrainingApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
            ->with('security.user_security.user')
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

    public function updateStatus(
        OwnedTrainingParticipantStatusRequest $request,
        string $uuid,
        string $applicationUuid,
    ): JsonResponse {
        if ($request->user()?->role !== 'bujp') {
            throw new NotFoundHttpException('BUJP profile not found.');
        }

        $owner = $this->owner($request);
        $training = Training::query()
            ->where('uuid', $uuid)
            ->where('b_u_j_p_id', $owner['id'])
            ->firstOrFail();
        $status = $request->validated('status');

        $result = DB::transaction(function () use ($applicationUuid, $status, $training): array {
            $training = Training::query()
                ->lockForUpdate()
                ->findOrFail($training->id);

            $application = TrainingApplication::query()
                ->where('uuid', $applicationUuid)
                ->where('training_id', $training->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($status === 'approved' && $application->status !== 'approved') {
                $quota = is_numeric($training->quota) ? (int) $training->quota : 0;
                $approvedCount = TrainingApplication::query()
                    ->where('training_id', $training->id)
                    ->where('status', 'approved')
                    ->count();

                if ($quota > 0 && $approvedCount >= $quota) {
                    return [
                        'error' => 'The training quota is full.',
                        'status' => 422,
                    ];
                }
            }

            $application->update(['status' => $status]);

            $approvedCount = TrainingApplication::query()
                ->where('training_id', $training->id)
                ->where('status', 'approved')
                ->count();
            $training->update(['registered' => (string) $approvedCount]);
            $application->load('security.user_security.user');

            return ['application' => $application];
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
            'message' => 'Training participant status updated successfully.',
            'data' => [
                'training_participant' => (new TrainingParticipantResource($application))->resolve(),
            ],
        ]);
    }
}
