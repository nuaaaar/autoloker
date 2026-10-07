<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\JobBookmark;

use App\Models\JobVacancy;

use App\Models\Security;

use App\Models\CleaningService;

use Auth;

class JobBookmarkController extends Controller
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
     * Get kolom owner bookmark berdasarkan role user.
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
    public function update(
        Request $request,
        JobBookmark $jobBookmark
    ) {
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
        | CHECK BOOKMARK
        |--------------------------------------------------------------------------
        */

        $bookmark = JobBookmark::where(
                $ownerColumn,
                $security->id
            )
            ->where(
                'job_vacancy_id',
                $job->id
            )
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
            $ownerColumn => $security->id,
            'job_vacancy_id' => $job->id,
        ]);

        return response()->json([
            'success' => true,
            'saved' => true,
            'message' => 'Lowongan berhasil disimpan.'
        ]);
    }
}