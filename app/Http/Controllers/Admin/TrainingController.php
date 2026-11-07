<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use Illuminate\Support\Facades\Validator;
use App\Services\NotificationService;

class TrainingController extends Controller
{
    public function show($id)
    {
        $data['data'] = Training::where('uuid', $id)->first();

        return view('dashboard-admin.training.show', $data);
    }


    public function start($uuid)
    {
        $data = Training::where('uuid', $uuid)->firstOrFail();

        if ($data->status !== 'published') {

            return response()->json([
                'status'  => false,
                'message' => 'Pelatihan hanya dapat dimulai apabila berstatus Published.'
            ], 422);

        }

        $data->update([
            'status' => 'running'
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pelatihan berhasil dimulai.'
        ]);
    }

    public function close(Request $request, $uuid)
    {
        $data = Training::where('uuid', $uuid)->firstOrFail();

        if ($data->status !== 'running') {

            return response()->json([
                'status'  => false,
                'message' => 'Pelatihan hanya dapat ditutup apabila sedang Running.'
            ], 422);

        }

        $data->update([
            'status' => 'closed'
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pelatihan berhasil ditutup.'
        ]);
    }

    public function cancel(Request $request, $uuid)
    {
        $data = Training::where('uuid', $uuid)->firstOrFail();

        if (!in_array($data->status, [
            'published',
            'running'
        ])) {

            return response()->json([
                'status'  => false,
                'message' => 'Pelatihan tidak dapat dibatalkan pada status saat ini.'
            ], 422);

        }

        $request->validate([
            'reason_cancelled' => 'required|string|max:1000'
        ], [
            'reason_cancelled.required' => 'Alasan pembatalan wajib diisi.',
            'reason_cancelled.max'      => 'Alasan pembatalan maksimal 1000 karakter.'
        ]);

        $data->update([
            'status'           => 'cancelled',
            'reason_cancelled' => $request->reason_cancelled
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pelatihan berhasil dibatalkan.'
        ]);
    }


    public function destroy($uuid)
    {
        $data = Training::where('uuid', $uuid)->first();

        if (!$data) {

            return response()->json([
                'status' => false,
                'message' => 'Data pelatihan tidak ditemukan.'
            ], 404);

        }

        if ($data->status !== 'cancelled') {

            return response()->json([
                'status' => false,
                'message' => 'Hanya pelatihan yang dibatalkan yang dapat dihapus.'
            ], 422);

        }

        DB::transaction(function () use ($data) {

            $data->delete();

        });

        return response()->json([
            'status' => true,
            'message' => 'Pelatihan berhasil dihapus.'
        ]);
    }
}
