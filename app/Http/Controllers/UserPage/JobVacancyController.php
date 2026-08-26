<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\JobBookmark;
use App\Models\JobVacancy;
use App\Models\Security;
use Carbon\Carbon;
use Auth;

class JobVacancyController extends Controller
{
    public function index()
    {
        $security = Security::with([
            'badgeCertificate',
            'histories',
        ])->findOrFail(
            Auth::user()->user_security->security->id
        );

        return view(
            'user-page.job-vacancy.index',
            compact('security')
        );
    }

    public function show($uuid)
    {
        $security = Auth::user()
            ->user_security
            ->security;


        /*
        |--------------------------------------------------------------------------
        | CARI LOWONGAN
        |--------------------------------------------------------------------------
        */

        $job = JobVacancy::query()

            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])

            ->withCount(['bookmarks', 'applications'])

            ->where('uuid', $uuid)

            ->firstOrFail();

            $job->increment('total_clicked');


        /*
        |--------------------------------------------------------------------------
        | APPLICATION USER
        |--------------------------------------------------------------------------
        */

        $application = JobApplication::query()

            ->where('job_vacancy_id', $job->id)

            ->where('security_id', $security->id)

            ->first();


        /*
        |--------------------------------------------------------------------------
        | CEK AKSES DETAIL
        |--------------------------------------------------------------------------
        |
        | Jika lowongan masih aktif:
        |   Semua user boleh melihat.
        |
        | Jika lowongan sudah tidak aktif:
        |   Hanya user yang sudah pernah melamar yang boleh melihat.
        |
        */

        $isPublished = $job->status === 'published';

        $isNotExpired =
            is_null($job->end_date) ||
            $job->end_date >= now()->toDateString();


        if (
            (!$isPublished || !$isNotExpired)
            && !$application
        ) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | BOOKMARK
        |--------------------------------------------------------------------------
        */

        $job->loadExists([

            'bookmarks as is_bookmarked' => function ($query) use ($security) {

                $query->where(
                    'security_id',
                    $security->id
                );

            },

            'applications as is_applied' => function ($query) use ($security) {

                $query->where(
                    'security_id',
                    $security->id
                );

            },

        ]);


        /*
        |--------------------------------------------------------------------------
        | STATUS APPLICATION
        |--------------------------------------------------------------------------
        */

        $applicationStatus = $application?->status;


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.job-vacancy.show',
            compact(
                'job',
                'application',
                'applicationStatus'
            )
        );
    }

    public function bookmark(Request $request)
    {
        $security = Auth::user()
            ->user_security
            ->security;


        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        $sort = $request->get('sort', 'latest');

        $allowedSort = [
            'latest',
            'deadline',
            'applicants',
        ];

        if (!in_array($sort, $allowedSort)) {
            $sort = 'latest';
        }


        /*
        |--------------------------------------------------------------------------
        | QUERY BOOKMARK
        |--------------------------------------------------------------------------
        */

        $query = JobBookmark::query()

            ->where(
                'job_bookmarks.security_id',
                $security->id
            )

            ->whereHas('job_vacancy', function ($query) {
                $query->where('status', 'published');
            })

            ->with([
                'job_vacancy' => function ($query) use ($security) {

                    $query->with([
                        'bujp:id,company_name',
                        'company:id,company_name',
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | JUMLAH PELAMAR
                    |--------------------------------------------------------------------------
                    */

                    $query->withCount('applications');


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS LAMARAN SECURITY
                    |--------------------------------------------------------------------------
                    */

                    $query->with([
                        'applications' => function ($query) use ($security) {

                            $query
                                ->where(
                                    'security_id',
                                    $security->id
                                )
                                ->select([
                                    'id',
                                    'job_vacancy_id',
                                    'security_id',
                                    'status',
                                ]);

                        }
                    ]);

                }
            ]);


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            /*
            |--------------------------------------------------------------------------
            | TERBARU DISIMPAN
            |--------------------------------------------------------------------------
            */

            case 'latest':

                $query->orderBy(
                    'job_bookmarks.created_at',
                    'desc'
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | DEADLINE TERDEKAT
            |--------------------------------------------------------------------------
            */

            case 'deadline':

                $query

                    ->leftJoin(
                        'job_vacancies',
                        'job_vacancies.id',
                        '=',
                        'job_bookmarks.job_vacancy_id'
                    )

                    ->select(
                        'job_bookmarks.*'
                    )

                    ->orderByRaw("
                        CASE
                            WHEN job_vacancies.end_date IS NULL
                            THEN 1
                            ELSE 0
                        END ASC
                    ")

                    ->orderBy(
                        'job_vacancies.end_date',
                        'asc'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | PELAMAR TERSEDIKIT
            |--------------------------------------------------------------------------
            */

            case 'applicants':

                $query

                    ->select(
                        'job_bookmarks.*'
                    )

                    ->selectSub(
                        JobApplication::query()
                            ->selectRaw('COUNT(*)')
                            ->whereColumn(
                                'job_applications.job_vacancy_id',
                                'job_bookmarks.job_vacancy_id'
                            ),
                        'applicants_count'
                    )

                    ->orderBy(
                        'applicants_count',
                        'asc'
                    );

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $bookmarks = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | TOTAL BOOKMARK
        |--------------------------------------------------------------------------
        */

        $totalBookmarks = JobBookmark::query()

            ->where(
                'security_id',
                $security->id
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL BOOKMARK YANG SUDAH DILAMAR
        |--------------------------------------------------------------------------
        */

        $totalAppliedBookmarks = JobBookmark::query()

            ->where(
                'security_id',
                $security->id
            )

            ->whereHas(
                'job_vacancy.applications',
                function ($query) use ($security) {

                    $query->where(
                        'job_applications.security_id',
                        $security->id
                    );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL LOWONGAN URGENT
        |--------------------------------------------------------------------------
        */

        $totalUrgent = JobBookmark::query()

            ->where(
                'security_id',
                $security->id
            )

            ->whereHas(
                'job_vacancy',
                function ($query) {

                    $query->where(
                        'job_vacancies.is_urgent',
                        1
                    );

                }
            )

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
                    'user-page.job-vacancy.partials.bookmark-list',
                    compact('bookmarks')
                )->render(),

                'current_page' =>
                    $bookmarks->currentPage(),

                'last_page' =>
                    $bookmarks->lastPage(),

                'has_more' =>
                    $bookmarks->hasMorePages(),

                'total' =>
                    $bookmarks->total(),

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.job-vacancy.bookmark',
            compact(
                'bookmarks',
                'totalBookmarks',
                'totalAppliedBookmarks',
                'totalUrgent',
                'sort'
            )
        );
    }

    public function myJobVacancy()
    {
        $security = Auth::user()
            ->user_security
            ->security;

        $securityId = $security->id;


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalApplications = JobApplication::query()
            ->where('security_id', $securityId)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | APPLIED
        |--------------------------------------------------------------------------
        */

        $totalApplied = JobApplication::query()
            ->where('security_id', $securityId)
            ->where('status', 'applied')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | REVIEWED
        |--------------------------------------------------------------------------
        */

        $totalReviewed = JobApplication::query()
            ->where('security_id', $securityId)
            ->where('status', 'reviewed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SHORTLISTED
        |--------------------------------------------------------------------------
        */

        $totalShortlisted = JobApplication::query()
            ->where('security_id', $securityId)
            ->where('status', 'shortlisted')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | REJECTED
        |--------------------------------------------------------------------------
        */

        $totalRejected = JobApplication::query()
            ->where('security_id', $securityId)
            ->where('status', 'rejected')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | AKTIF
        |--------------------------------------------------------------------------
        |
        | applied + reviewed
        |
        */

        $totalActive =
            $totalApplied +
            $totalReviewed;


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.job-vacancy.my',
            compact(
                'security',
                'totalApplications',
                'totalActive',
                'totalApplied',
                'totalReviewed',
                'totalShortlisted',
                'totalRejected'
            )
        );
    }

    public function list(Request $request)
    {
        $security = Security::with([
            'badgeCertificate',
            'histories',
        ])
        ->findOrFail(
            Auth::user()->user_security->security->id
        );

        $securityId = $security->id;


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $search = trim($request->get('search', ''));

        $province = $request->get('province');

        $workingType = $request->get('working_type');

        $workingSystem = $request->get('working_system');

        $certificate = $request->get('certificate');


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = JobVacancy::query()

            /*
            |--------------------------------------------------------------------------
            | COMPANY
            |--------------------------------------------------------------------------
            */

            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])

            ->withCount(['bookmarks', 'applications'])


            /*
            |--------------------------------------------------------------------------
            | BOOKMARK
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'bookmarks as is_bookmarked' => function ($query) use ($securityId) {

                    $query->where(
                        'security_id',
                        $securityId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | APPLICATION - SUDAH MELAMAR
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'applications as is_applied' => function ($query) use ($securityId) {

                    $query->where(
                        'security_id',
                        $securityId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | APPLICATION STATUS
            |--------------------------------------------------------------------------
            |
            | Mengambil status application milik security yang sedang login.
            |
            | Hasil:
            | applied
            | reviewed
            | shortlisted
            | rejected
            | null = belum melamar
            |
            */

            ->selectSub(
                JobApplication::query()
                    ->select('status')

                    ->whereColumn(
                        'job_applications.job_vacancy_id',
                        'job_vacancies.id'
                    )

                    ->where(
                        'job_applications.security_id',
                        $securityId
                    )

                    ->latest('id')

                    ->limit(1),

                'application_status'
            )


            /*
            |--------------------------------------------------------------------------
            | JUMLAH PELAMAR
            |--------------------------------------------------------------------------
            */

            ->withCount('applications')


            /*
            |--------------------------------------------------------------------------
            | STATUS LOWONGAN
            |--------------------------------------------------------------------------
            */

            ->where(
                'status',
                'published'
            )


            /*
            |--------------------------------------------------------------------------
            | DEADLINE
            |--------------------------------------------------------------------------
            */

            ->where(function ($query) {

                $query
                    ->whereNull('end_date')

                    ->orWhereDate(
                        'end_date',
                        '>=',
                        now()->toDateString()
                    );

            });


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $query->where(function ($query) use ($search) {

                $query

                    ->where(
                        'position',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'province',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'company',
                        function ($query) use ($search) {

                            $query->where(
                                'company_name',
                                'LIKE',
                                "%{$search}%"
                            );

                        }
                    )

                    ->orWhereHas(
                        'bujp',
                        function ($query) use ($search) {

                            $query->where(
                                'company_name',
                                'LIKE',
                                "%{$search}%"
                            );

                        }
                    );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | PROVINCE
        |--------------------------------------------------------------------------
        */

        if ($province) {

            /*
            |--------------------------------------------------------------------------
            | Kalau job_vacancies.province menyimpan CODE
            |--------------------------------------------------------------------------
            */

            $query->where(
                'province',
                $province
            );

        }


        /*
        |--------------------------------------------------------------------------
        | JENIS PEKERJAAN
        |--------------------------------------------------------------------------
        */

        if ($workingType) {

            $query->where(
                'working_type',
                $workingType
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SISTEM KERJA
        |--------------------------------------------------------------------------
        */

        if ($workingSystem) {

            $query->where(
                'working_system',
                $workingSystem
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SERTIFIKAT
        |--------------------------------------------------------------------------
        */

        if ($certificate) {

            /*
            |--------------------------------------------------------------------------
            | certificate disimpan sebagai JSON
            |--------------------------------------------------------------------------
            */

            $query->whereJsonContains(
                'certificate',
                $certificate
            );

        }


        /*
        |--------------------------------------------------------------------------
        | MIN SALARY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('min_salary')) {

            $query->where(
                'min_price',
                '>=',
                (float) $request->min_salary
            );

        }


        /*
        |--------------------------------------------------------------------------
        | URGENT
        |--------------------------------------------------------------------------
        */

        if ($request->filled('urgent')) {

            $query->where(
                'is_urgent',
                $request->urgent
            );

        }


        /*
        |--------------------------------------------------------------------------
        | EXPERIENCE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('experience')) {

            $experience = (int) $request->experience;

            /*
            |--------------------------------------------------------------------------
            | TANPA PENGALAMAN
            |--------------------------------------------------------------------------
            */

            if ($experience === 0) {

                $query->where(function ($query) {

                    $query

                        ->whereNull('min_experience')

                        ->orWhere(
                            'min_experience',
                            ''
                        )

                        ->orWhere(
                            'min_experience',
                            '0'
                        );

                });

            }

            /*
            |--------------------------------------------------------------------------
            | DENGAN PENGALAMAN
            |--------------------------------------------------------------------------
            */

            else {

                /*
                |--------------------------------------------------------------------------
                | Karena min_experience berupa text seperti:
                |
                | "1 tahun"
                | "Minimal 2 tahun"
                |--------------------------------------------------------------------------
                */

                $query->whereRaw(
                    "CAST(
                        REGEXP_SUBSTR(
                            min_experience,
                            '[0-9]+'
                        )
                    AS UNSIGNED) <= ?",
                    [
                        $experience
                    ]
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | GENDER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('gender')) {

            $query->where(function ($query) use ($request) {

                $query

                    ->whereNull('gender')

                    ->orWhere(
                        'gender',
                        $request->gender
                    );

            });

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

        $jobs = $query

            ->paginate(10)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return response()->json([

                'success' => true,

                'html' => view(
                    'user-page.job-vacancy.partials.list',
                    compact('jobs')
                )->render(),

                'current_page' =>
                    $jobs->currentPage(),

                'last_page' =>
                    $jobs->lastPage(),

                'has_more' =>
                    $jobs->hasMorePages(),

                'total' =>
                    $jobs->total(),

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL RESPONSE
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.job-vacancy.partials.list',
            compact('jobs')
        );
    }

    public function myJobVacancyList(Request $request)
    {
        $security = Auth::user()
            ->user_security
            ->security;

        $securityId = $security->id;


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $status = $request->get('status');

        $search = trim(
            $request->get('search', '')
        );


        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        $sort = $request->get(
            'sort',
            'latest'
        );

        $allowedSort = [
            'latest',
            'oldest',
            'deadline',
        ];

        if (!in_array(
            $sort,
            $allowedSort
        )) {

            $sort = 'latest';

        }


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = JobApplication::query()

            ->where(
                'security_id',
                $securityId
            )


            /*
            |--------------------------------------------------------------------------
            | LOWONGAN
            |--------------------------------------------------------------------------
            */

            ->with([

                'job_vacancy' => function ($query) {

                    $query->with([

                        'bujp:id,company_name',

                        'company:id,company_name',

                    ]);

                }

            ]);


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $status &&
            in_array(
                $status,
                [
                    'applied',
                    'reviewed',
                    'shortlisted',
                    'rejected',
                ]
            )
        ) {

            $query->where(
                'status',
                $status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $query->whereHas(
                'job_vacancy',
                function ($query) use ($search) {

                    $query->where(function ($query) use ($search) {

                        $query

                            ->where(
                                'position',
                                'LIKE',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'city',
                                'LIKE',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'province',
                                'LIKE',
                                "%{$search}%"
                            )

                            ->orWhereHas(
                                'company',
                                function ($query) use ($search) {

                                    $query->where(
                                        'company_name',
                                        'LIKE',
                                        "%{$search}%"
                                    );

                                }
                            )

                            ->orWhereHas(
                                'bujp',
                                function ($query) use ($search) {

                                    $query->where(
                                        'company_name',
                                        'LIKE',
                                        "%{$search}%"
                                    );

                                }
                            );

                    });

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            /*
            |--------------------------------------------------------------------------
            | TERBARU
            |--------------------------------------------------------------------------
            */

            case 'latest':

                $query->orderBy(
                    'created_at',
                    'desc'
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | TERLAMA
            |--------------------------------------------------------------------------
            */

            case 'oldest':

                $query->orderBy(
                    'created_at',
                    'asc'
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | DEADLINE
            |--------------------------------------------------------------------------
            */

            case 'deadline':

                $query
                    ->leftJoin(
                        'job_vacancies',
                        'job_vacancies.id',
                        '=',
                        'job_applications.job_vacancy_id'
                    )

                    ->select(
                        'job_applications.*'
                    )

                    ->orderByRaw("
                        CASE
                            WHEN job_vacancies.end_date IS NULL
                            THEN 1
                            ELSE 0
                        END ASC
                    ")

                    ->orderBy(
                        'job_vacancies.end_date',
                        'asc'
                    );

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $applications = $query
            ->paginate(5)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return response()->json([

                'success' => true,

                'html' => view(
                    'user-page.job-vacancy.partials.my-list',
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
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.job-vacancy.partials.my-list',
            compact('applications')
        );
    }
}
