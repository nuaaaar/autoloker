<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use Illuminate\Support\Facades\Validator;

class JobVacancyController extends Controller
{
    public function show($id)
    {
        $data['data'] = JobVacancy::where('uuid', $id)->first();

        return view('dashboard-admin.job-vacancy.show', $data);
    }

    public function publish($uuid)
    {
        $job = JobVacancy::where('uuid', $uuid)->firstOrFail();

        if ($job->status != 'submitted') {

            return response()->json([
                'status'  => false,
                'message' => 'Lowongan tidak dapat dipublikasikan.'
            ], 422);

        }

        $job->update([

            'status' => 'published',
            'reason_rejected' => null,

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Lowongan berhasil dipublikasikan.'

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

        $job = JobVacancy::where('uuid', $uuid)->firstOrFail();

        if ($job->status != 'submitted') {

            return response()->json([
                'status'  => false,
                'message' => 'Lowongan tidak dapat ditolak.'
            ], 422);

        }

        $job->update([

            'status' => 'rejected',

            'reason_rejected' => $request->reason_rejected

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Lowongan berhasil ditolak.'

        ]);

    }

    public function destroy(Request $request)
    {
        $request->validate([
            'uuid' => [
                'required',
                'string',
                'exists:job_vacancies,uuid',
            ],
        ]);

        try {

            DB::beginTransaction();

            $job = JobVacancy::where(
                'uuid',
                $request->uuid
            )->firstOrFail();

            $job->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lowongan berhasil dihapus.',
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Lowongan gagal dihapus.',
            ], 500);
        }
    }
}
