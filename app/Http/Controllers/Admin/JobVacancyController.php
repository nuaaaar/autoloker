<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use Illuminate\Support\Facades\Validator;
use App\Services\NotificationService;

class JobVacancyController extends Controller
{
    public function show($id)
    {
        $data['data'] = JobVacancy::where('uuid', $id)->first();

        return view('dashboard-admin.job-vacancy.show', $data);
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
