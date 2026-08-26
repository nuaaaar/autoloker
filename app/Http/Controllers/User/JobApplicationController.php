<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\JobVacancy;

class JobApplicationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Daftar seluruh pelamar dari sebuah lowongan
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, $uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | LOWONGAN
        |--------------------------------------------------------------------------
        */

        $job = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->where('uuid', $uuid)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | QUERY PELAMAR
        |--------------------------------------------------------------------------
        */

        $query = JobApplication::query()
            ->with([
                'security',
            ])
            ->where(
                'job_vacancy_id',
                $job->id
            );


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->whereHas(
                'security',
                function ($q) use ($search) {

                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('ktp_number', 'LIKE', "%{$search}%");

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        $query->latest('id');


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $applications = $query
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | STATISTIC
        |--------------------------------------------------------------------------
        */

        $total = JobApplication::where(
            'job_vacancy_id',
            $job->id
        )->count();


        $applied = JobApplication::where(
            'job_vacancy_id',
            $job->id
        )
        ->where('status', 'applied')
        ->count();


        $reviewed = JobApplication::where(
            'job_vacancy_id',
            $job->id
        )
        ->where('status', 'reviewed')
        ->count();


        $shortlisted = JobApplication::where(
            'job_vacancy_id',
            $job->id
        )
        ->where('status', 'shortlisted')
        ->count();


        $rejected = JobApplication::where(
            'job_vacancy_id',
            $job->id
        )
        ->where('status', 'rejected')
        ->count();


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return response()->json([

                'success' => true,

                'html' => view(
                    'dashboard-user.job-application.partials.list',
                    compact('applications')
                )->render(),

                'current_page' =>
                    $applications->currentPage(),

                'last_page' =>
                    $applications->lastPage(),

                'has_more' =>
                    $applications->hasMorePages(),

                'total' =>
                    $applications->total(),

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-user.job-application.index',
            compact(
                'job',
                'applications',
                'total',
                'applied',
                'reviewed',
                'shortlisted',
                'rejected'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    | Detail satu pelamar
    |--------------------------------------------------------------------------
    */

    public function show($uuid, $application)
    {
        /*
        |--------------------------------------------------------------------------
        | LOWONGAN
        |--------------------------------------------------------------------------
        */

        $job = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->where('uuid', $uuid)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | PELAMAR
        |--------------------------------------------------------------------------
        */

        $application = JobApplication::query()
            ->with([
                'security',
            ])
            ->where(
                'id',
                $application
            )
            ->where(
                'job_vacancy_id',
                $job->id
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-user.job-application.show',
            compact(
                'job',
                'application'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        $uuid,
        $application
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'status' => [
                'required',
                'in:applied,reviewed,shortlisted,rejected'
            ]
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOWONGAN
        |--------------------------------------------------------------------------
        */

        $job = JobVacancy::query()
            ->where('uuid', $uuid)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | PELAMAR
        |--------------------------------------------------------------------------
        */

        $application = JobApplication::query()
            ->where('id', $application)
            ->where(
                'job_vacancy_id',
                $job->id
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $application->update([
            'status' => $request->status
        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Status pelamar berhasil diperbarui.',
            'status' => $application->status,
        ]);
    }
}
