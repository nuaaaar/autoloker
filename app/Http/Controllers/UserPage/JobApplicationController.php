<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Security;
use Auth;

class JobApplicationController extends Controller
{
    
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
    public function update(Request $request, JobApplication $jobApplication)
    {
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
        $security = Auth::user()
        ->user_security
        ->security;
        
        $job = JobVacancy::where('uuid', $uuid)
        ->where('status', 'published')
        ->firstOrFail();
        
        // Cek apakah sudah pernah melamar
        $application = JobApplication::where('security_id', $security->id)
        ->where('job_vacancy_id', $job->id)
        ->first();

        if ($application) {

            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melamar lowongan ini.'
            ], 422);

        }

        // Cek deadline
        if (
            $job->end_date &&
            now()->startOfDay()->gt($job->end_date)
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Masa pendaftaran lowongan sudah berakhir.'
            ], 422);

        }

        // Cek kuota
        if ($job->kuota) {

            $totalApplicant = JobApplication::where(
                'job_vacancy_id',
                $job->id
            )
            ->count();

            if ($totalApplicant >= $job->kuota) {

                return response()->json([
                    'success' => false,
                    'message' => 'Kuota pelamar sudah penuh.'
                ], 422);

            }

        }

        JobApplication::create([
            'security_id' => $security->id,
            'job_vacancy_id' => $job->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim.'
        ]);
    }

    public function cancelApplication($uuid)
    {
        $security = Auth::user()
            ->user_security
            ->security;

        $job = JobVacancy::where('uuid', $uuid)
            ->firstOrFail();

        $application = JobApplication::where('security_id', $security->id)
            ->where('job_vacancy_id', $job->id)
            ->first();

        if (!$application) {

            return response()->json([
                'success' => false,
                'message' => 'Anda belum melamar lowongan ini.'
            ], 404);

        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dibatalkan.'
        ]);
    }
}
