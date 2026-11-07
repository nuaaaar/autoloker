<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Security;
use App\Models\CleaningService;
use App\Services\NotificationService;
use App\Services\WebNotificationService;
use Auth;

class JobApplicationController extends Controller
{
    /**
     * Get profile berdasarkan role user.
     */
    private function getProfile()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return $user->user_security?->security;
        }

        if ($user->role === 'cs') {
            return $user->user_cleaning_service?->cleaning_service;
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Get category berdasarkan role user.
     */
    private function getCategory()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return 'security';
        }

        if ($user->role === 'cs') {
            return 'cs';
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Get owner column berdasarkan role user.
     */
    private function getOwnerColumn()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return 'security_id';
        }

        if ($user->role === 'cs') {
            return 'cleaning_service_id';
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        JobApplication $jobApplication
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Apply job vacancy.
     */
    public function apply($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Data profile belum tersedia.'
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK PROFILE 100%
        |--------------------------------------------------------------------------
        */

        $profileProgress = $profile->profileProgress();

        if ($profileProgress['progress'] < 100) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi profile terlebih dahulu sebelum melamar pekerjaan.',
                'progress' => $profileProgress['progress'],
                'completed' => $profileProgress['completed'],
                'total' => $profileProgress['total'],
                'missing' => $profileProgress['missing'],
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY & OWNER
        |--------------------------------------------------------------------------
        */

        $category = $this->getCategory();
        $ownerColumn = $this->getOwnerColumn();

        /*
        |--------------------------------------------------------------------------
        | JOB
        |--------------------------------------------------------------------------
        */

        $job = JobVacancy::where('uuid', $uuid)
            ->where('category', $category)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH SUDAH PERNAH MELAMAR
        |--------------------------------------------------------------------------
        */

        $securityId = Auth::user()->user_security?->security?->id;
        $cleaningServiceId = Auth::user()->user_cleaning_service?->cleaning_service?->id;
        $result = DB::transaction(function () use ($job, $ownerColumn, $profile, $securityId, $cleaningServiceId): array {
            $job = JobVacancy::query()->lockForUpdate()->findOrFail($job->id);

            if (!$job->isCurrentlyPublished()) {
                return ['error' => 'Masa pendaftaran lowongan sudah berakhir.'];
            }

            $application = JobApplication::where('job_vacancy_id', $job->id)
                ->where(function ($profiles) use ($securityId, $cleaningServiceId) {
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
                return ['error' => 'Anda sudah melamar lowongan ini.'];
            }

            if ($job->kuota && JobApplication::where('job_vacancy_id', $job->id)->count() >= $job->kuota) {
                return ['error' => 'Kuota pelamar sudah penuh.'];
            }

            JobApplication::create([
                $ownerColumn => $profile->id,
                'job_vacancy_id' => $job->id,
            ]);

            return ['job' => $job];
        });

        if (isset($result['error'])) {
            return response()->json([
                'success' => false,
                'message' => $result['error'],
            ], 422);
        }
        $job = $result['job'];
        $owner = $job->company?->userCompany?->user ?? $job->bujp?->userBujp?->user;

        if ($owner) {
            app(NotificationService::class)->send($owner->id, 'job_application_created', [
                'position' => $job->position,
                'applicant' => Auth::user()->name,
                'vacancy_uuid' => rawurlencode((string) $job->uuid),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim.'
        ]);
    }

    /**
     * Cancel job application.
     */
    public function cancelApplication($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Data profile belum tersedia.'
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY & OWNER
        |--------------------------------------------------------------------------
        */

        $category = $this->getCategory();
        $ownerColumn = $this->getOwnerColumn();

        /*
        |--------------------------------------------------------------------------
        | JOB
        |--------------------------------------------------------------------------
        */

        $job = JobVacancy::where('uuid', $uuid)
            ->where('category', $category)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | FIND APPLICATION
        |--------------------------------------------------------------------------
        */

        $application = JobApplication::where(
                $ownerColumn,
                $profile->id
            )
            ->where(
                'job_vacancy_id',
                $job->id
            )
            ->first();

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melamar lowongan ini.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE APPLICATION
        |--------------------------------------------------------------------------
        */

        $application->delete();

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dibatalkan.'
        ]);
    }
}