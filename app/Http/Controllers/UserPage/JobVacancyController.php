<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\JobBookmark;
use App\Models\JobVacancy;
use App\Models\Security;
use App\Models\CleaningService;
use Carbon\Carbon;
use Auth;

class JobVacancyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PROFILE SESUAI ROLE
    |--------------------------------------------------------------------------
    |
    | Variable yang digunakan di Blade tetap $security.
    |
    | satpam -> Security
    | cs     -> CleaningService
    |
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


    /*
    |--------------------------------------------------------------------------
    | CATEGORY JOB
    |--------------------------------------------------------------------------
    |
    | satpam -> security
    | cs     -> cs
    |
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


    /*
    |--------------------------------------------------------------------------
    | OWNER COLUMN
    |--------------------------------------------------------------------------
    |
    | Variable $securityId tetap digunakan.
    |
    | satpam -> security_id
    | cs     -> cleaning_service_id
    |
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


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $security = $this->getProfile();

        if (!$security) {

            return redirect()
                ->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Profile Belum Tersedia',
                    'text' => 'Silakan lengkapi data profile terlebih dahulu.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | LOAD PROFILE RELATION
        |--------------------------------------------------------------------------
        */

        $security->load([
            'badgeCertificate',
            'histories',
        ]);


        return view(
            'user-page.job-vacancy.index',
            compact('security')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($uuid)
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $ownerColumn = $this->getOwnerColumn();

        $category = $this->getCategory();


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

            ->withCount([
                'bookmarks',
                'applications',
            ])

            ->where(
                'uuid',
                $uuid
            )

            /*
            |--------------------------------------------------------------------------
            | WAJIB SESUAI CATEGORY ROLE
            |--------------------------------------------------------------------------
            */

            ->where(
                'category',
                $category
            )

            ->firstOrFail();


        $job->increment('total_clicked');


        /*
        |--------------------------------------------------------------------------
        | APPLICATION USER
        |--------------------------------------------------------------------------
        */

        $application = JobApplication::query()

            ->where(
                'job_vacancy_id',
                $job->id
            )

            ->where(
                $ownerColumn,
                $securityId
            )

            ->first();


        /*
        |--------------------------------------------------------------------------
        | CEK AKSES DETAIL
        |--------------------------------------------------------------------------
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

            'bookmarks as is_bookmarked' => function ($query) use (
                $ownerColumn,
                $securityId
            ) {

                $query->where(
                    $ownerColumn,
                    $securityId
                );

            },

            'applications as is_applied' => function ($query) use (
                $ownerColumn,
                $securityId
            ) {

                $query->where(
                    $ownerColumn,
                    $securityId
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


    /*
    |--------------------------------------------------------------------------
    | BOOKMARK
    |--------------------------------------------------------------------------
    */

    public function bookmark(Request $request)
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $ownerColumn = $this->getOwnerColumn();

        $category = $this->getCategory();


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
            'deadline',
            'applicants',
        ];

        if (!in_array(
            $sort,
            $allowedSort
        )) {

            $sort = 'latest';

        }


        /*
        |--------------------------------------------------------------------------
        | QUERY BOOKMARK
        |--------------------------------------------------------------------------
        */

        $query = JobBookmark::query()

            ->where(
                'job_bookmarks.' . $ownerColumn,
                $securityId
            )


            /*
            |--------------------------------------------------------------------------
            | LOWONGAN HARUS SESUAI CATEGORY
            |--------------------------------------------------------------------------
            */

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query
                        ->where(
                            'status',
                            'published'
                        )
                        ->where(
                            'category',
                            $category
                        );

                }
            )


            /*
            |--------------------------------------------------------------------------
            | JOB VACANCY
            |--------------------------------------------------------------------------
            */

            ->with([
                'job_vacancy' => function ($query) use (
                    $ownerColumn,
                    $securityId
                ) {

                    $query->with([
                        'bujp:id,company_name',
                        'company:id,company_name',
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | JUMLAH PELAMAR
                    |--------------------------------------------------------------------------
                    */

                    $query->withCount(
                        'applications'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS LAMARAN USER
                    |--------------------------------------------------------------------------
                    */

                    $query->with([
                        'applications' => function ($query) use (
                            $ownerColumn,
                            $securityId
                        ) {

                            $query
                                ->where(
                                    $ownerColumn,
                                    $securityId
                                )
                                ->select([
                                    'id',
                                    'job_vacancy_id',
                                    $ownerColumn,
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

                    ->where(
                        'job_vacancies.category',
                        $category
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
                $ownerColumn,
                $securityId
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL BOOKMARK YANG SUDAH DILAMAR
        |--------------------------------------------------------------------------
        */

        $totalAppliedBookmarks = JobBookmark::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

            ->whereHas(
                'job_vacancy.applications',
                function ($query) use (
                    $ownerColumn,
                    $securityId
                ) {

                    $query->where(
                        'job_applications.' . $ownerColumn,
                        $securityId
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
                $ownerColumn,
                $securityId
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query
                        ->where(
                            'job_vacancies.category',
                            $category
                        )
                        ->where(
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


    /*
    |--------------------------------------------------------------------------
    | MY JOB VACANCY
    |--------------------------------------------------------------------------
    */

    public function myJobVacancy()
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $ownerColumn = $this->getOwnerColumn();

        $category = $this->getCategory();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalApplications = JobApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | APPLIED
        |--------------------------------------------------------------------------
        */

        $totalApplied = JobApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->where(
                'status',
                'applied'
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | REVIEWED
        |--------------------------------------------------------------------------
        */

        $totalReviewed = JobApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->where(
                'status',
                'reviewed'
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | SHORTLISTED
        |--------------------------------------------------------------------------
        */

        $totalShortlisted = JobApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->where(
                'status',
                'shortlisted'
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | REJECTED
        |--------------------------------------------------------------------------
        */

        $totalRejected = JobApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->where(
                'status',
                'rejected'
            )

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
            )

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


    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function list(Request $request)
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $security->load([
            'badgeCertificate',
            'histories',
        ]);

        $securityId = $security->id;

        $ownerColumn = $this->getOwnerColumn();

        $category = $this->getCategory();


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->get(
                'search',
                ''
            )
        );

        $province = $request->get(
            'province'
        );

        $workingType = $request->get(
            'working_type'
        );

        $workingSystem = $request->get(
            'working_system'
        );

        $certificate = $request->get(
            'certificate'
        );


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


            /*
            |--------------------------------------------------------------------------
            | JUMLAH BOOKMARK + APPLICATION
            |--------------------------------------------------------------------------
            */

            ->withCount([
                'bookmarks',
                'applications',
            ])


            /*
            |--------------------------------------------------------------------------
            | BOOKMARK
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'bookmarks as is_bookmarked' => function ($query) use (
                    $ownerColumn,
                    $securityId
                ) {

                    $query->where(
                        $ownerColumn,
                        $securityId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | APPLICATION
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'applications as is_applied' => function ($query) use (
                    $ownerColumn,
                    $securityId
                ) {

                    $query->where(
                        $ownerColumn,
                        $securityId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | APPLICATION STATUS
            |--------------------------------------------------------------------------
            */

            ->selectSub(

                JobApplication::query()

                    ->select('status')

                    ->whereColumn(
                        'job_applications.job_vacancy_id',
                        'job_vacancies.id'
                    )

                    ->where(
                        $ownerColumn,
                        $securityId
                    )

                    ->latest('id')

                    ->limit(1),

                'application_status'

            )


            /*
            |--------------------------------------------------------------------------
            | CATEGORY SESUAI ROLE
            |--------------------------------------------------------------------------
            */

            ->where(
                'category',
                $category
            )


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

                    ->whereNull(
                        'end_date'
                    )

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

        if ($request->filled(
            'min_salary'
        )) {

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

        if ($request->filled(
            'urgent'
        )) {

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

        if ($request->filled(
            'experience'
        )) {

            $experience = (int) $request->experience;


            /*
            |--------------------------------------------------------------------------
            | TANPA PENGALAMAN
            |--------------------------------------------------------------------------
            */

            if ($experience === 0) {

                $query->where(function ($query) {

                    $query

                        ->whereNull(
                            'min_experience'
                        )

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

        if ($request->filled(
            'gender'
        )) {

            $query->where(function ($query) use (
                $request
            ) {

                $query

                    ->whereNull(
                        'gender'
                    )

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

        $query->latest(
            'id'
        );


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


    /*
    |--------------------------------------------------------------------------
    | MY JOB VACANCY LIST
    |--------------------------------------------------------------------------
    */

    public function myJobVacancyList(Request $request)
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $ownerColumn = $this->getOwnerColumn();

        $category = $this->getCategory();


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $status = $request->get(
            'status'
        );

        $search = trim(
            $request->get(
                'search',
                ''
            )
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
        | QUERY APPLICATION
        |--------------------------------------------------------------------------
        */

        $query = JobApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )


            /*
            |--------------------------------------------------------------------------
            | LOWONGAN HARUS SESUAI CATEGORY
            |--------------------------------------------------------------------------
            */

            ->whereHas(
                'job_vacancy',
                function ($query) use ($category) {

                    $query->where(
                        'category',
                        $category
                    );

                }
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

                    $query->where(function ($query) use (
                        $search
                    ) {

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
                                function ($query) use (
                                    $search
                                ) {

                                    $query->where(
                                        'company_name',
                                        'LIKE',
                                        "%{$search}%"
                                    );

                                }
                            )

                            ->orWhereHas(
                                'bujp',
                                function ($query) use (
                                    $search
                                ) {

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

                    /*
                    |--------------------------------------------------------------------------
                    | CATEGORY TETAP DIJAGA
                    |--------------------------------------------------------------------------
                    */

                    ->where(
                        'job_vacancies.category',
                        $category
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