<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobBookmark;
use App\Models\JobVacancy;
use App\Models\Security;
use Auth;

class JobBookmarkController extends Controller
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
    public function show(JobBookmark $jobBookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBookmark $jobBookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobBookmark $jobBookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobBookmark $jobBookmark)
    {
        //
    }

    public function bookmark($uuid)
    {
        $security = Auth::user()
            ->user_security
            ->security;

        $job = JobVacancy::where('uuid', $uuid)
            ->where('status', 'published')
            ->firstOrFail();

        $bookmark = JobBookmark::where('security_id', $security->id)
            ->where('job_vacancy_id', $job->id)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | UNSAVE
        |--------------------------------------------------------------------------
        */

        if ($bookmark) {

            $bookmark->delete();

            return response()->json([
                'success' => true,
                'saved' => false,
                'message' => 'Lowongan dihapus dari simpanan.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        JobBookmark::create([
            'security_id' => $security->id,
            'job_vacancy_id' => $job->id,
        ]);

        return response()->json([
            'success' => true,
            'saved' => true,
            'message' => 'Lowongan berhasil disimpan.'
        ]);
    }
}
