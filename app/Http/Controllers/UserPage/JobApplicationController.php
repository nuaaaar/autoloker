<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;

use App\Models\JobApplication;

use Illuminate\Http\Request;

use App\Models\JobVacancy;

use App\Models\Security;

use App\Models\CleaningService;

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

    public function apply($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $security = $this->getProfile();

        if (!$security) {
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
            ->where('status', 'published')
            ->where('category', $category)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH SUDAH PERNAH MELAMAR
        |--------------------------------------------------------------------------
        */

        $application = JobApplication::where(
                $ownerColumn,
                $security->id
            )
            ->where(
                'job_vacancy_id',
                $job->id
            )
            ->first();

        if ($application) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melamar lowongan ini.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK DEADLINE
        |--------------------------------------------------------------------------
        */

        if (
            $job->end_date &&
            now()->startOfDay()->gt($job->end_date)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Masa pendaftaran lowongan sudah berakhir.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK KUOTA
        |--------------------------------------------------------------------------
        */

        if ($job->kuota) {

            $totalApplicant = JobApplication::where(
                'job_vacancy_id',
                $job->id
            )->count();

            if ($totalApplicant >= $job->kuota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota pelamar sudah penuh.'
                ], 422);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE APPLICATION
        |--------------------------------------------------------------------------
        */

        JobApplication::create([
            $ownerColumn => $security->id,
            'job_vacancy_id' => $job->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim.'
        ]);
    }

    public function cancelApplication($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $security = $this->getProfile();

        if (!$security) {
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
                $security->id
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

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dibatalkan.'
        ]);
    }
}