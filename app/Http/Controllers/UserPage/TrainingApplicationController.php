<?php

namespace App\Http\Controllers\UserPage;

use App\Models\TrainingApplication;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Training;

use App\Models\Security;

use App\Models\CleaningService;

use Auth;

class TrainingApplicationController extends Controller
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
     * Get category_role berdasarkan role user.
     */
    private function getCategoryRole()
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

    public function applyTraining($uuid)
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
                'message' => 'Lengkapi profile terlebih dahulu sebelum mendaftar pelatihan.',
                'progress' => $profileProgress['progress'],
                'missing' => $profileProgress['missing'],
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY ROLE & OWNER
        |--------------------------------------------------------------------------
        */
        $categoryRole = $this->getCategoryRole();
        $ownerColumn = $this->getOwnerColumn();

        /*
        |--------------------------------------------------------------------------
        | TRAINING
        |--------------------------------------------------------------------------
        */
        $training = Training::where('uuid', $uuid)
            ->where('category_role', $categoryRole)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH SUDAH MEMILIKI PENDAFTARAN AKTIF
        |--------------------------------------------------------------------------
        */
        $application = TrainingApplication::where(
            $ownerColumn,
            $profile->id
        )
            ->where('training_id', $training->id)
            ->whereIn('status', [
                'pending',
                'approved'
            ])
            ->first();

        if ($application) {

            if ($application->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar pada pelatihan ini.'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Anda masih menunggu persetujuan.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK TANGGAL MULAI
        |--------------------------------------------------------------------------
        */
        if (
            $training->start_date &&
            now()->startOfDay()->gt($training->start_date)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran pelatihan sudah ditutup.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK KUOTA
        |--------------------------------------------------------------------------
        | HANYA YANG APPROVED
        |--------------------------------------------------------------------------
        */
        if ($training->quota > 0) {

            $totalApproved = TrainingApplication::where(
                'training_id',
                $training->id
            )
                ->where('status', 'approved')
                ->count();

            if ($totalApproved >= $training->quota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota peserta pelatihan sudah penuh.'
                ], 422);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BUAT PENDAFTARAN
        |--------------------------------------------------------------------------
        */
        TrainingApplication::create([
            $ownerColumn => $profile->id,
            'training_id' => $training->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran pelatihan berhasil dikirim dan menunggu persetujuan.'
        ]);
    }

    public function cancelTrainingApplication($uuid)
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
        | CATEGORY ROLE & OWNER
        |--------------------------------------------------------------------------
        */

        $categoryRole = $this->getCategoryRole();

        $ownerColumn = $this->getOwnerColumn();

        /*
        |--------------------------------------------------------------------------
        | TRAINING
        |--------------------------------------------------------------------------
        */

        $training = Training::where('uuid', $uuid)
            ->where('category_role', $categoryRole)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CARI PENDAFTARAN
        |--------------------------------------------------------------------------
        */

        $application = TrainingApplication::where(
            $ownerColumn,
            $security->id
        )
            ->where('training_id', $training->id)
            ->first();

        if (!$application) {

            return response()->json([
                'success' => false,
                'message' => 'Anda belum mendaftar pelatihan ini.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | HANYA PENDING YANG BOLEH DIBATALKAN
        |--------------------------------------------------------------------------
        */

        if ($application->status !== 'pending') {

            if ($application->status === 'approved') {

                $message = 'Pendaftaran yang sudah disetujui tidak dapat dibatalkan.';

            } else {

                $message = 'Pendaftaran ini tidak dapat dibatalkan.';
            }

            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE APPLICATION
        |--------------------------------------------------------------------------
        */

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran pelatihan berhasil dibatalkan.'
        ]);
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
    public function show(TrainingApplication $trainingApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingApplication $trainingApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        TrainingApplication $trainingApplication
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        TrainingApplication $trainingApplication
    ) {
        //
    }
}