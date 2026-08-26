<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    public function show($id)
    {
        $data['data'] = Training::where('uuid', $id)->first();

        return view('dashboard-admin.training.show', $data);
    }

    public function publish($uuid)
    {
        $job = Training::where('uuid', $uuid)->firstOrFail();

        if ($job->status != 'submitted') {

            return response()->json([
                'status'  => false,
                'message' => 'Pelatihan tidak dapat dipublikasikan.'
            ], 422);

        }

        $job->update([

            'status' => 'published',
            'reason_rejected' => null,

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Pelatihan berhasil dipublikasikan.'

        ]);
    }

    public function reject(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [

            'reason_rejected' => 'required|string|min:10|max:1000'

        ],[

            'reason_rejected.required' => 'Alasan penolakan wajib diisi.',
            'reason_rejected.min'      => 'Alasan penolakan minimal 10 karakter.',
            'reason_rejected.max'      => 'Alasan penolakan maksimal 1000 karakter.'

        ]);

        if ($validator->fails()) {

            return response()->json([

                'status' => false,
                'errors' => $validator->errors()

            ],422);

        }

        $job = Training::where('uuid', $uuid)->firstOrFail();

        if ($job->status != 'submitted') {

            return response()->json([
                'status'  => false,
                'message' => 'Pelatihan tidak dapat ditolak.'
            ], 422);

        }

        $job->update([

            'status' => 'rejected',

            'reason_rejected' => $request->reason_rejected

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Pelatihan berhasil ditolak.'

        ]);

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

    public function restore($uuid)
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
                'message' => 'Pelatihan tidak dalam status dibatalkan.'
            ], 422);

        }

        DB::transaction(function () use ($data) {

            $data->update([
                'status' => 'published'
            ]);

        });

        return response()->json([
            'status' => true,
            'message' => 'Pelatihan berhasil diaktifkan kembali.'
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
