<?php

namespace App\Http\Controllers\UserPage;

use App\Models\TrainingApplication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Security;
use Auth;

class TrainingApplicationController extends Controller
{

    public function applyTraining($uuid)
    {
        $security = Auth::user()
            ->user_security
            ->security;

        $training = Training::where('uuid', $uuid)
            ->firstOrFail();

        // Cek apakah sudah memiliki pendaftaran aktif
        $application = TrainingApplication::where('security_id', $security->id)
            ->where('training_id', $training->id)
            ->whereIn('status', ['pending', 'approved'])
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

        // Cek tanggal mulai
        if (
            $training->start_date &&
            now()->startOfDay()->gt($training->start_date)
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran pelatihan sudah ditutup.'
            ], 422);
        }

        // =====================================================
        // CEK KUOTA - HANYA YANG APPROVED
        // =====================================================

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

        // =====================================================
        // BUAT PENDAFTARAN
        // =====================================================

        TrainingApplication::create([
            'security_id' => $security->id,
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
        $security = Auth::user()
            ->user_security
            ->security;

        $training = Training::where('uuid', $uuid)
            ->firstOrFail();

        $application = TrainingApplication::where(
            'security_id',
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

        // HANYA PENDING YANG BOLEH DIBATALKAN
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
    public function update(Request $request, TrainingApplication $trainingApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingApplication $trainingApplication)
    {
        //
    }
}
