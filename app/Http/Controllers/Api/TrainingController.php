<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TrainingIndexRequest;
use App\Http\Resources\Api\TrainingResource;
use App\Models\Training;
use App\Models\TrainingApplication;
use App\Services\Api\ApplicantProfileResolver;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    private const PER_PAGE = 5;

    public function __construct(private readonly ApplicantProfileResolver $applicants) {}

    /**
     * List published trainings targeted at the active applicant role.
     */
    public function index(TrainingIndexRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $applicant = $this->applicants->resolve($request->user());
        $column = $applicant['column'];
        $profileId = $applicant['profile_id'];

        $query = Training::query()
            ->with([
                'bujp:id,company_name,logo',
                'company:id,company_name,logo',
            ])
            ->withCount([
                'applications as approved_applications_count' => function (Builder $query): void {
                    $query->where('status', 'approved');
                },
            ])
            ->withExists([
                'applications as is_applied' => function (Builder $query) use ($column, $profileId): void {
                    $query->whereNotNull($column)
                        ->where($column, $profileId);
                },
            ])
            ->where('category_role', $applicant['category'])
            ->currentlyPublished();

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

    public function show(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();
        $application = null;
        $query = Training::query()->where('uuid', $uuid);

        if ($user->role === 'company') {
            $query->where('company_id', $user->user_company?->company?->id ?? 0);
        }

        $training = $query
            ->with(['bujp:id,company_name', 'company:id,company_name'])
            ->withCount(['applications as approved_applications_count' => function (Builder $applications): void {
                $applications->where('status', 'approved');
            }])
            ->firstOrFail();

        if ($user->role !== 'company') {
            $securityId = $user->user_security?->security?->id;
            $cleaningServiceId = $user->user_cleaning_service?->cleaning_service?->id;
            $application = $training->applications()
                ->where(function (Builder $profiles) use ($securityId, $cleaningServiceId): void {
                    if ($securityId !== null) {
                        $profiles->where('security_id', $securityId);
                    }
                    if ($cleaningServiceId !== null) {
                        $method = $securityId !== null ? 'orWhere' : 'where';
                        $profiles->{$method}('cleaning_service_id', $cleaningServiceId);
                    }
                })
                ->first();

            $roleCategory = match ($user->role) {
                'satpam' => 'security',
                'cs' => 'cs',
                default => null,
            };
            $archivableStatuses = ['published', 'closed', 'running', 'cancelled'];
            if (
                !in_array($training->status, $archivableStatuses, true)
                || ($training->category_role !== $roleCategory && !$application)
            ) {
                abort(404);
            }

            if ($application) {
                $training->setAttribute('is_applied', true);
                $training->setAttribute('application_uuid', $application->uuid);
                $training->setAttribute('application_status', $application->status);
                $training->setAttribute('applied_at', $application->created_at);
                $training->setAttribute('application_updated_at', $application->updated_at);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Pelatihan berhasil diambil.',
            'data' => ['training' => (new TrainingResource($training))->resolve()],
        ]);
    }

    public function store(Request $request, string $uuid): JsonResponse
    {
        $applicant = $this->applicants->resolve($request->user());
        $training = Training::query()
            ->where('uuid', $uuid)
            ->where('category_role', $applicant['category'])
            ->firstOrFail();

        $profile = $applicant['profile'];
        $progress = $profile->profileProgress();

        if ($progress['completed'] < $progress['total']) {
            return response()->json([
                'status' => false,
                'message' => 'Lengkapi profil Anda sebelum mendaftar pelatihan.',
                'data' => [
                    'progress' => $progress['progress'],
                    'completed' => $progress['completed'],
                    'total' => $progress['total'],
                    'missing' => $progress['missing'],
                ],
            ], 422);
        }

        $column = $applicant['column'];
        $profileId = $applicant['profile_id'];
        $securityId = $request->user()->user_security?->security?->id;
        $cleaningServiceId = $request->user()->user_cleaning_service?->cleaning_service?->id;

        $result = DB::transaction(function () use ($training, $column, $profileId, $securityId, $cleaningServiceId): array {
            $training = Training::query()
                ->lockForUpdate()
                ->findOrFail($training->id);

            if ($training->status !== 'published') {
                return [
                    'error' => 'Pelatihan ini tidak tersedia untuk pendaftaran.',
                    'status' => 404,
                ];
            }

            $application = TrainingApplication::query()
                ->where('training_id', $training->id)
                ->where(function (Builder $profiles) use ($securityId, $cleaningServiceId): void {
                    if ($securityId !== null) {
                        $profiles->where('security_id', $securityId);
                    }
                    if ($cleaningServiceId !== null) {
                        $method = $securityId !== null ? 'orWhere' : 'where';
                        $profiles->{$method}('cleaning_service_id', $cleaningServiceId);
                    }
                })
                ->first();

            if ($application) {
                return [
                    'error' => match ($application->status) {
                        'approved' => 'Anda sudah terdaftar dalam pelatihan ini.',
                        'pending' => 'Pendaftaran pelatihan Anda sedang menunggu persetujuan.',
                        default => 'Anda sudah pernah mendaftar pada pelatihan ini.',
                    },
                    'status' => 422,
                ];
            }

            if (!$training->isCurrentlyPublished() || ($training->start_date && now()->gte($training->start_date))) {
                return [
                    'error' => 'Pendaftaran pelatihan telah ditutup.',
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
                        'error' => "Kuota pelatihan penuh ({$approvedCount}/{$quota} peserta disetujui). Pendaftaran tidak dapat dilakukan.",
                        'status' => 422,
                    ];
                }
            }

            return [
                'application' => TrainingApplication::create([
                    $column => $profileId,
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

        $owner = $training->company?->userCompany?->user ?? $training->bujp?->userBujp?->user;

        if ($owner) {
            app(NotificationService::class)->send($owner->id, 'training_application_created', [
                'training' => $training->title,
                'participant' => $request->user()->name,
                'training_uuid' => rawurlencode((string) $training->uuid),
            ]);
        }


        return response()->json([
            'status' => true,
            'message' => 'Pendaftaran pelatihan berhasil dikirim.',
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
}
