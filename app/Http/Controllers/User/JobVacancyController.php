<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\District;
use App\Models\MasterCertificate;
use App\Models\MasterCompetencyScheme;
use App\Models\MasterPositionSecurity;
use App\Models\MasterPositionCleaningService;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\City;
use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Auth;

class JobVacancyController extends Controller
{

    public function statistic()
    {
        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CARI OWNER
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'bujp') {

            $ownerColumn = 'b_u_j_p_id';

            $ownerId = $user
                ->user_bujp
                ->bujp
                ->id;

        } else {

            $ownerColumn = 'company_id';

            $ownerId = $user
                ->user_company
                ->company
                ->id;
        }


        /*
        |--------------------------------------------------------------------------
        | BASE JOB QUERY
        |--------------------------------------------------------------------------
        */
        $jobQuery = JobVacancy::where(
            $ownerColumn,
            $ownerId
        );


        /*
        |--------------------------------------------------------------------------
        | STATISTIK LOWONGAN
        |--------------------------------------------------------------------------
        */
        $totalJobs = (clone $jobQuery)->count();

        $publishedJobs = (clone $jobQuery)
            ->where('status', 'published')
            ->count();

        $draftJobs = (clone $jobQuery)
            ->where('status', 'draft')
            ->count();

        $closedJobs = (clone $jobQuery)
            ->where('status', 'closed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | BASE APPLICATION QUERY
        |--------------------------------------------------------------------------
        */
        $applicationQuery = JobApplication::whereHas(
            'job_vacancy',
            function ($q) use ($ownerColumn, $ownerId) {

                $q->where(
                    $ownerColumn,
                    $ownerId
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL APPLICATION
        |--------------------------------------------------------------------------
        */
        $totalApplications = (clone $applicationQuery)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ACTIVE APPLICATION
        |--------------------------------------------------------------------------
        */
        $activeApplications = (clone $applicationQuery)
            ->whereIn(
                'status',
                [
                    'applied',
                    'reviewed',
                    'shortlisted',
                ]
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | APPLICATION STATUS
        |--------------------------------------------------------------------------
        */
        $appliedApplications = (clone $applicationQuery)
            ->where(
                'status',
                'applied'
            )
            ->count();

        $reviewedApplications = (clone $applicationQuery)
            ->where(
                'status',
                'reviewed'
            )
            ->count();

        $shortlistedApplications = (clone $applicationQuery)
            ->where(
                'status',
                'shortlisted'
            )
            ->count();

        $rejectedApplications = (clone $applicationQuery)
            ->where(
                'status',
                'rejected'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | CONVERSION RATE
        |--------------------------------------------------------------------------
        */
        $reviewRate = $totalApplications > 0
            ? round(
                ($reviewedApplications / $totalApplications) * 100,
                1
            )
            : 0;

        $shortlistRate = $totalApplications > 0
            ? round(
                ($shortlistedApplications / $totalApplications) * 100,
                1
            )
            : 0;

        $rejectionRate = $totalApplications > 0
            ? round(
                ($rejectedApplications / $totalApplications) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | STATISTIK BERDASARKAN CATEGORY
        |--------------------------------------------------------------------------
        |
        | security = Satpam
        | cs       = Cleaning Service
        |
        */
        $categoryStatistics = [];


        /*
        |--------------------------------------------------------------------------
        | SECURITY / SATPAM
        |--------------------------------------------------------------------------
        */
        $securityJobQuery = (clone $jobQuery)
            ->where('category', 'security');

        $securityApplicationQuery = (clone $applicationQuery)
            ->whereHas(
                'job_vacancy',
                function ($q) use ($ownerColumn, $ownerId) {

                    $q->where(
                        $ownerColumn,
                        $ownerId
                    )
                    ->where(
                        'category',
                        'security'
                    );
                }
            );


        $securityTotalJobs = (clone $securityJobQuery)
            ->count();

        $securityPublishedJobs = (clone $securityJobQuery)
            ->where('status', 'published')
            ->count();

        $securityDraftJobs = (clone $securityJobQuery)
            ->where('status', 'draft')
            ->count();

        $securityClosedJobs = (clone $securityJobQuery)
            ->where('status', 'closed')
            ->count();

        $securityTotalApplications = (clone $securityApplicationQuery)
            ->count();

        $securityActiveApplications = (clone $securityApplicationQuery)
            ->whereIn(
                'status',
                [
                    'applied',
                    'reviewed',
                    'shortlisted',
                ]
            )
            ->count();

        $securityAppliedApplications = (clone $securityApplicationQuery)
            ->where('status', 'applied')
            ->count();

        $securityReviewedApplications = (clone $securityApplicationQuery)
            ->where('status', 'reviewed')
            ->count();

        $securityShortlistedApplications = (clone $securityApplicationQuery)
            ->where('status', 'shortlisted')
            ->count();

        $securityRejectedApplications = (clone $securityApplicationQuery)
            ->where('status', 'rejected')
            ->count();


        $securityReviewRate = $securityTotalApplications > 0
            ? round(
                ($securityReviewedApplications / $securityTotalApplications) * 100,
                1
            )
            : 0;

        $securityShortlistRate = $securityTotalApplications > 0
            ? round(
                ($securityShortlistedApplications / $securityTotalApplications) * 100,
                1
            )
            : 0;

        $securityRejectionRate = $securityTotalApplications > 0
            ? round(
                ($securityRejectedApplications / $securityTotalApplications) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | CLEANING SERVICE
        |--------------------------------------------------------------------------
        */
        $csJobQuery = (clone $jobQuery)
            ->where('category', 'cs');

        $csApplicationQuery = (clone $applicationQuery)
            ->whereHas(
                'job_vacancy',
                function ($q) use ($ownerColumn, $ownerId) {

                    $q->where(
                        $ownerColumn,
                        $ownerId
                    )
                    ->where(
                        'category',
                        'cs'
                    );
                }
            );


        $csTotalJobs = (clone $csJobQuery)
            ->count();

        $csPublishedJobs = (clone $csJobQuery)
            ->where('status', 'published')
            ->count();

        $csDraftJobs = (clone $csJobQuery)
            ->where('status', 'draft')
            ->count();

        $csClosedJobs = (clone $csJobQuery)
            ->where('status', 'closed')
            ->count();

        $csTotalApplications = (clone $csApplicationQuery)
            ->count();

        $csActiveApplications = (clone $csApplicationQuery)
            ->whereIn(
                'status',
                [
                    'applied',
                    'reviewed',
                    'shortlisted',
                ]
            )
            ->count();

        $csAppliedApplications = (clone $csApplicationQuery)
            ->where('status', 'applied')
            ->count();

        $csReviewedApplications = (clone $csApplicationQuery)
            ->where('status', 'reviewed')
            ->count();

        $csShortlistedApplications = (clone $csApplicationQuery)
            ->where('status', 'shortlisted')
            ->count();

        $csRejectedApplications = (clone $csApplicationQuery)
            ->where('status', 'rejected')
            ->count();


        $csReviewRate = $csTotalApplications > 0
            ? round(
                ($csReviewedApplications / $csTotalApplications) * 100,
                1
            )
            : 0;

        $csShortlistRate = $csTotalApplications > 0
            ? round(
                ($csShortlistedApplications / $csTotalApplications) * 100,
                1
            )
            : 0;

        $csRejectionRate = $csTotalApplications > 0
            ? round(
                ($csRejectedApplications / $csTotalApplications) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | CATEGORY STATISTICS ARRAY
        |--------------------------------------------------------------------------
        */
        $categoryStatistics = [

            'security' => [

                'label' => 'Satpam',

                'totalJobs' => $securityTotalJobs,
                'publishedJobs' => $securityPublishedJobs,
                'draftJobs' => $securityDraftJobs,
                'closedJobs' => $securityClosedJobs,

                'totalApplications' => $securityTotalApplications,
                'activeApplications' => $securityActiveApplications,

                'appliedApplications' => $securityAppliedApplications,
                'reviewedApplications' => $securityReviewedApplications,
                'shortlistedApplications' => $securityShortlistedApplications,
                'rejectedApplications' => $securityRejectedApplications,

                'reviewRate' => $securityReviewRate,
                'shortlistRate' => $securityShortlistRate,
                'rejectionRate' => $securityRejectionRate,
            ],

            'cs' => [

                'label' => 'Cleaning Service',

                'totalJobs' => $csTotalJobs,
                'publishedJobs' => $csPublishedJobs,
                'draftJobs' => $csDraftJobs,
                'closedJobs' => $csClosedJobs,

                'totalApplications' => $csTotalApplications,
                'activeApplications' => $csActiveApplications,

                'appliedApplications' => $csAppliedApplications,
                'reviewedApplications' => $csReviewedApplications,
                'shortlistedApplications' => $csShortlistedApplications,
                'rejectedApplications' => $csRejectedApplications,

                'reviewRate' => $csReviewRate,
                'shortlistRate' => $csShortlistRate,
                'rejectionRate' => $csRejectionRate,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | TOP 5 LOWONGAN BERDASARKAN PELAMAR
        |--------------------------------------------------------------------------
        */
        $topJobs = (clone $jobQuery)
            ->withCount('applications')
            ->whereNotNull('position')
            ->orderByDesc('applications_count')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MONTHLY STATISTICS
        |--------------------------------------------------------------------------
        */
        $monthlyJobs = (clone $jobQuery)
            ->selectRaw(
                'MONTH(created_at) as month,
                COUNT(*) as total'
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->groupByRaw(
                'MONTH(created_at)'
            )
            ->orderBy(
                'month'
            )
            ->pluck(
                'total',
                'month'
            );


        /*
        |--------------------------------------------------------------------------
        | MONTHLY APPLICATION
        |--------------------------------------------------------------------------
        */
        $monthlyApplications = (clone $applicationQuery)
            ->selectRaw(
                'MONTH(created_at) as month,
                COUNT(*) as total'
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->groupByRaw(
                'MONTH(created_at)'
            )
            ->orderBy(
                'month'
            )
            ->pluck(
                'total',
                'month'
            );


        /*
        |--------------------------------------------------------------------------
        | MONTH LABEL
        |--------------------------------------------------------------------------
        */
        $monthLabels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];


        /*
        |--------------------------------------------------------------------------
        | MONTHLY DATA
        |--------------------------------------------------------------------------
        */
        $jobChartData = [];
        $applicationChartData = [];

        for ($month = 1; $month <= 12; $month++) {

            $jobChartData[] =
                $monthlyJobs[$month] ?? 0;

            $applicationChartData[] =
                $monthlyApplications[$month] ?? 0;
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'dashboard-user.job-vacancy.statistic',
            compact(
                'totalJobs',
                'publishedJobs',
                'draftJobs',
                'closedJobs',

                'totalApplications',
                'activeApplications',

                'appliedApplications',
                'reviewedApplications',
                'shortlistedApplications',
                'rejectedApplications',

                'reviewRate',
                'shortlistRate',
                'rejectionRate',

                'topJobs',

                'monthLabels',
                'jobChartData',
                'applicationChartData',

                'categoryStatistics'
            )
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATATABLE AJAX
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            /*
            |--------------------------------------------------------------------------
            | DATATABLE PARAMETER
            |--------------------------------------------------------------------------
            */

            $searchValue = $request->input('search.value');

            $orderColumn = $request->input(
                'order.0.column',
                0
            );

            $orderSort = $request->input(
                'order.0.dir',
                'asc'
            );

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data',
                'id'
            );


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $status = $request->input(
                'status',
                $request->query('status', 'all')
            );


            /*
            |--------------------------------------------------------------------------
            | VALIDASI STATUS
            |--------------------------------------------------------------------------
            */

            $allowedStatus = [
                'all',
                'draft',
                'published',
                'closed',
            ];

            if (!in_array($status, $allowedStatus)) {

                $status = 'all';

            }


            /*
            |--------------------------------------------------------------------------
            | QUERY
            |--------------------------------------------------------------------------
            */

            $query = JobVacancy::query()

                ->withCount([

                    /*
                    |--------------------------------------------------------------------------
                    | BOOKMARK
                    |--------------------------------------------------------------------------
                    */

                    'bookmarks',


                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL APPLICATION
                    |--------------------------------------------------------------------------
                    */

                    'applications',


                    /*
                    |--------------------------------------------------------------------------
                    | REVIEWED
                    |--------------------------------------------------------------------------
                    */

                    'applications as reviewed_count' => function ($q) {

                        $q->where(
                            'status',
                            'reviewed'
                        );

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | SHORTLISTED
                    |--------------------------------------------------------------------------
                    */

                    'applications as shortlisted_count' => function ($q) {

                        $q->where(
                            'status',
                            'shortlisted'
                        );

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | REJECTED
                    |--------------------------------------------------------------------------
                    */

                    'applications as rejected_count' => function ($q) {

                        $q->where(
                            'status',
                            'rejected'
                        );

                    },

                ]);


            /*
            |--------------------------------------------------------------------------
            | OWNER
            |--------------------------------------------------------------------------
            */

            $query->where(function ($q) {

                if (Auth::user()->role === 'bujp') {

                    $q->where(
                        'b_u_j_p_id',
                        Auth::user()
                            ->user_bujp
                            ->bujp
                            ->id
                    );

                } else {

                    $q->where(
                        'company_id',
                        Auth::user()
                            ->user_company
                            ->company
                            ->id
                    );

                }

            });


            /*
            |--------------------------------------------------------------------------
            | FILTER STATUS
            |--------------------------------------------------------------------------
            */

            if ($status !== 'all') {

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

            if ($searchValue) {

                $query->where(function ($q) use ($searchValue) {

                    $q->where(
                        'position',
                        'like',
                        '%' . $searchValue . '%'
                    )

                    ->orWhere(
                        'province',
                        'like',
                        '%' . $searchValue . '%'
                    )

                    ->orWhere(
                        'city',
                        'like',
                        '%' . $searchValue . '%'
                    )

                    ->orWhere(
                        'min_fee',
                        'like',
                        '%' . $searchValue . '%'
                    )

                    ->orWhere(
                        'max_fee',
                        'like',
                        '%' . $searchValue . '%'
                    )

                    ->orWhere(
                        'status',
                        'like',
                        '%' . $searchValue . '%'
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | ORDER
            |--------------------------------------------------------------------------
            */

            $query->orderBy(
                $orderValue,
                $orderSort
            );


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            $data = $query->paginate(
                $request->input(
                    'length',
                    10
                )
            );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-user.job-vacancy.index'
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Saat halaman pertama dibuka belum ada category
        // sehingga data master dikosongkan terlebih dahulu.
        $positions = collect();

        $master_certificates = collect();

        $master_competency_schemes = collect();

        return view(
            'dashboard-user.job-vacancy.create',
            compact(
                'positions',
                'master_certificates',
                'master_competency_schemes'
            )
        );
    }


    /**
     * Mengambil master data berdasarkan category.
     *
     * security = Satpam
     * cs       = Cleaning Service
     */
    public function masterData(Request $request)
    {
        $request->validate([
            'category' => [
                'required',
                'in:security,cs',
            ],
        ]);

        $category = $request->category;

        /*
        |--------------------------------------------------------------------------
        | POSITION
        |--------------------------------------------------------------------------
        | security = MasterPositionSecurity
        | cs       = MasterPositionCleaningService
        |--------------------------------------------------------------------------
        */

        if ($category === 'security') {

            $positions = MasterPositionSecurity::query()
                ->orderBy('title')
                ->get([
                    'id',
                    'uuid',
                    'title',
                ]);

        } else {

            $positions = MasterPositionCleaningService::query()
                ->orderBy('title')
                ->get([
                    'id',
                    'uuid',
                    'title',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CERTIFICATE
        |--------------------------------------------------------------------------
        */

        $master_certificates = MasterCertificate::query()
            ->where('category', $category)
            ->orderBy('title')
            ->get([
                'id',
                'uuid',
                'title',
            ]);


        /*
        |--------------------------------------------------------------------------
        | COMPETENCY SCHEME
        |--------------------------------------------------------------------------
        */

        $master_competency_schemes = MasterCompetencyScheme::query()
            ->where('category', $category)
            ->orderBy('title')
            ->get([
                'id',
                'uuid',
                'title',
            ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'positions' => $positions,

            'master_certificates' => $master_certificates,

            'master_competency_schemes' => $master_competency_schemes,
        ]);
    }

    public function getPosition(Request $request, $uuid)
    {
        $request->validate([
            'category' => [
                'required',
                'in:security,cs',
            ],
        ]);

        $category = $request->category;

        /*
        |--------------------------------------------------------------------------
        | POSITION
        |--------------------------------------------------------------------------
        | security = MasterPositionSecurity
        | cs       = MasterPositionCleaningService
        |--------------------------------------------------------------------------
        */

        if ($category === 'security') {

            $position = MasterPositionSecurity::query()
                ->where('uuid', $uuid)
                ->firstOrFail();

        } else {

            $position = MasterPositionCleaningService::query()
                ->where('uuid', $uuid)
                ->firstOrFail();
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'data' => [

                'title' =>
                    $position->title,

                'description' =>
                    $position->description,

                'responsibility' =>
                    $position->responsibility ?? [],

            ]

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'position'          => 'required|string|max:255',
            'description_work'  => 'required',
            'responsibility'    => 'required',
            'facility'          => 'required',

            'kuota'             => 'required|integer|min:1',

            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',

            'province'          => 'required',
            'city'              => 'required',
            // 'district'          => 'required',
            // 'village'           => 'required',
            'address'           => 'required',

            'working_type'      => 'required',
            'working_system'    => 'required',

            'fee_type'          => 'required_if:is_show_fee,1',

            'min_price'         => 'required_if:is_show_fee,1',
            'max_price'         => 'required_if:is_show_fee,1',

            /*
            |--------------------------------------------------------------------------
            | USIA
            |--------------------------------------------------------------------------
            */

            'min_age'           => 'nullable|integer|min:17|max:100',

            'max_age'           => 'nullable|integer|min:17|max:100|gte:min_age',


            /*
            |--------------------------------------------------------------------------
            | TINGGI BADAN
            |--------------------------------------------------------------------------
            */

            'min_height'        => 'nullable|integer|min:100|max:250',

            'max_height'        => 'nullable|integer|min:100|max:250|gte:min_height',


            /*
            |--------------------------------------------------------------------------
            | BERAT BADAN
            |--------------------------------------------------------------------------
            */

            'min_weight'        => 'nullable|integer|min:20|max:300',

            'max_weight'        => 'nullable|integer|min:20|max:300|gte:min_weight',


            /*
            |--------------------------------------------------------------------------
            | PENGALAMAN
            |--------------------------------------------------------------------------
            */

            'min_experience'    => 'nullable|integer|min:0',

            'certificate'       => 'required|json',

            'competency_scheme'       => 'required|json',

        ], [

            'position.required'             => 'Posisi pekerjaan wajib diisi.',
            'description_work.required'     => 'Deskripsi pekerjaan wajib diisi.',
            'responsibility.required'       => 'Tanggung jawab wajib diisi.',
            'facility.required'             => 'Fasilitas & benefit wajib diisi.',

            'kuota.required'                => 'Kuota wajib diisi.',
            'kuota.integer'                 => 'Kuota harus berupa angka.',
            'kuota.min'                     => 'Kuota minimal 1 orang.',

            'start_date.required'           => 'Tanggal mulai wajib diisi.',
            'end_date.required'             => 'Tanggal berakhir wajib diisi.',
            'end_date.after_or_equal'       => 'Tanggal berakhir tidak boleh sebelum tanggal mulai.',

            'province.required'             => 'Provinsi wajib dipilih.',
            'city.required'                 => 'Kota/Kabupaten wajib dipilih.',
            // 'district.required'             => 'Kecamatan wajib dipilih.',
            // 'village.required'              => 'Kelurahan wajib dipilih.',
            'address.required'              => 'Alamat lengkap wajib diisi.',

            'working_type.required'         => 'Jenis pekerjaan wajib dipilih.',
            'working_system.required'       => 'Sistem kerja wajib dipilih.',

            'fee_type.required_if'          => 'Tipe gaji wajib dipilih.',

            'min_price.required_if'         => 'Gaji minimum wajib diisi.',
            'max_price.required_if'         => 'Gaji maksimum wajib diisi.',


            /*
            |--------------------------------------------------------------------------
            | USIA
            |--------------------------------------------------------------------------
            */

            'min_age.integer'               => 'Usia minimum harus berupa angka.',
            'max_age.integer'               => 'Usia maksimum harus berupa angka.',
            'max_age.gte'                   => 'Usia maksimum tidak boleh lebih kecil dari usia minimum.',


            /*
            |--------------------------------------------------------------------------
            | TINGGI BADAN
            |--------------------------------------------------------------------------
            */

            'min_height.integer'            => 'Tinggi badan minimum harus berupa angka.',
            'min_height.min'                => 'Tinggi badan minimum tidak boleh kurang dari 100 cm.',
            'min_height.max'                => 'Tinggi badan minimum tidak boleh lebih dari 250 cm.',

            'max_height.integer'            => 'Tinggi badan maksimum harus berupa angka.',
            'max_height.min'                => 'Tinggi badan maksimum tidak boleh kurang dari 100 cm.',
            'max_height.max'                => 'Tinggi badan maksimum tidak boleh lebih dari 250 cm.',
            'max_height.gte'                => 'Tinggi badan maksimum tidak boleh lebih kecil dari tinggi badan minimum.',


            /*
            |--------------------------------------------------------------------------
            | BERAT BADAN
            |--------------------------------------------------------------------------
            */

            'min_weight.integer'            => 'Berat badan minimum harus berupa angka.',
            'min_weight.min'                => 'Berat badan minimum tidak boleh kurang dari 20 kg.',
            'min_weight.max'                => 'Berat badan minimum tidak boleh lebih dari 300 kg.',

            'max_weight.integer'            => 'Berat badan maksimum harus berupa angka.',
            'max_weight.min'                => 'Berat badan maksimum tidak boleh kurang dari 20 kg.',
            'max_weight.max'                => 'Berat badan maksimum tidak boleh lebih dari 300 kg.',
            'max_weight.gte'                => 'Berat badan maksimum tidak boleh lebih kecil dari berat badan minimum.',


            /*
            |--------------------------------------------------------------------------
            | PENGALAMAN
            |--------------------------------------------------------------------------
            */

            'min_experience.integer'        => 'Minimal pengalaman harus berupa angka.',

            'certificate.required' =>
                'Sertifikasi wajib dipilih.',

            'certificate.json' =>
                'Format sertifikasi tidak valid.',

            'competency_scheme.required' =>
                'Kompetensi skema wajib dipilih.',

            'competency_scheme.json' =>
                'Format kompetensi skema tidak valid.',

        ]);

        $validator->after(function ($validator) use ($request) {

            $certificate = json_decode(
                $request->certificate,
                true
            );

            if (
                !is_array($certificate) ||
                count($certificate) === 0
            ) {

                $validator->errors()->add(
                    'certificate',
                    'Minimal pilih satu sertifikasi.'
                );

            }


            $competencyScheme = json_decode(
                $request->competency_scheme,
                true
            );

            if (
                !is_array($competencyScheme) ||
                count($competencyScheme) === 0
            ) {

                $validator->errors()->add(
                    'competency_scheme',
                    'Minimal pilih satu kompetensi skema.'
                );

            }

        });

        if ($validator->fails()) {

            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors()
            ],422);

        }

        $bujpId = null;
        $companyId = null;

        if(Auth::user()->role == 'bujp')
        {
            $bujpId = Auth::user()->user_bujp->bujp->id;
        } else {
            $companyId = Auth::user()->user_company->company->id;
        }
        
        $province = Province::where('code', $request->province)->first();
        $city = City::where('code', $request->city)->first();
        $district = District::where('code', $request->district)->first();
        $village = Village::where('code', $request->village)->first();

        JobVacancy::create([

            'b_u_j_p_id'       => $bujpId,
            'company_id'       => $companyId,

            'position'         => $request->position,
            'description_work' => $request->description_work,
            'responsibility'   => $request->responsibility,
            'facility'         => $request->facility,

            'kuota'            => $request->kuota,

            'status' => ($request->status === 'submitted')
            ? 'published'
            : ($request->status ?? 'draft'),

            'start_date'       => $request->start_date,
            'end_date'        => $request->end_date,

            'province'         => $province?->name,
            'city'             => $city?->name,
            'district'         => $district?->name,
            'village'          => $village?->name,
            'address'          => $request->address,

            'working_type'     => $request->working_type,
            'working_system'   => $request->working_system,

            'is_show_fee'      => $request->boolean('is_show_fee'),

            'fee_type'         => $request->fee_type,

            'min_price'        => str_replace('.', '', $request->min_price),
            'max_price'        => str_replace('.', '', $request->max_price),

            'gender'           => $request->gender,

            'min_age'          => $request->min_age,
            'max_age'          => $request->max_age,

            'min_height'       => $request->min_height,
            'max_height'       => $request->max_height,

            'min_weight'       => $request->min_weight,
            'max_weight'       => $request->max_weight,

            'last_education'   => $request->last_education,
            'min_experience'   => $request->min_experience,

            'certificate'      => $request->certificate,

            'competency_scheme'      => $request->competency_scheme,

            'category'      => $request->category,

            'is_urgent'        => $request->boolean('is_urgent'),

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Lowongan berhasil disimpan.'

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['data'] = JobVacancy::where('uuid', $id)->first();

        return view('dashboard-user.job-vacancy.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['data'] = JobVacancy::where('uuid', $id)->first();

        return view('dashboard-user.job-vacancy.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'position'          => 'required|string|max:255',
            'description_work'  => 'required',
            'responsibility'    => 'required',
            'facility'          => 'required',

            'kuota'             => 'required|integer|min:1',

            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',

            'province'          => 'required',
            'city'              => 'required',
            // 'district'       => 'required',
            // 'village'        => 'required',
            'address'           => 'required',

            'working_type'      => 'required',
            'working_system'    => 'required',

            'fee_type'          => 'required_if:is_show_fee,1',

            'min_price'         => 'required_if:is_show_fee,1',
            'max_price'         => 'required_if:is_show_fee,1',


            /*
            |--------------------------------------------------------------------------
            | USIA
            |--------------------------------------------------------------------------
            */

            'min_age'           => 'nullable|integer|min:17|max:100',

            'max_age'           => 'nullable|integer|min:17|max:100|gte:min_age',


            /*
            |--------------------------------------------------------------------------
            | TINGGI BADAN
            |--------------------------------------------------------------------------
            */

            'min_height'        => 'nullable|integer|min:100|max:250',

            'max_height'        => 'nullable|integer|min:100|max:250|gte:min_height',


            /*
            |--------------------------------------------------------------------------
            | BERAT BADAN
            |--------------------------------------------------------------------------
            */

            'min_weight'        => 'nullable|integer|min:20|max:300',

            'max_weight'        => 'nullable|integer|min:20|max:300|gte:min_weight',


            /*
            |--------------------------------------------------------------------------
            | PENGALAMAN
            |--------------------------------------------------------------------------
            */

            'min_experience'    => 'nullable|integer|min:0',

            'certificate'       => 'required|json',

            'competency_scheme'       => 'required|json',

        ], [

            'position.required'             => 'Posisi pekerjaan wajib diisi.',
            'description_work.required'     => 'Deskripsi pekerjaan wajib diisi.',
            'responsibility.required'       => 'Tanggung jawab wajib diisi.',
            'facility.required'             => 'Fasilitas & benefit wajib diisi.',

            'kuota.required'                => 'Kuota wajib diisi.',
            'kuota.integer'                 => 'Kuota harus berupa angka.',
            'kuota.min'                     => 'Kuota minimal 1 orang.',

            'start_date.required'           => 'Tanggal mulai wajib diisi.',
            'end_date.required'             => 'Tanggal berakhir wajib diisi.',
            'end_date.after_or_equal'       => 'Tanggal berakhir tidak boleh sebelum tanggal mulai.',

            'province.required'             => 'Provinsi wajib dipilih.',
            'city.required'                 => 'Kota/Kabupaten wajib dipilih.',
            // 'district.required'          => 'Kecamatan wajib dipilih.',
            // 'village.required'           => 'Kelurahan wajib dipilih.',
            'address.required'              => 'Alamat lengkap wajib diisi.',

            'working_type.required'         => 'Jenis pekerjaan wajib dipilih.',
            'working_system.required'       => 'Sistem kerja wajib dipilih.',

            'fee_type.required_if'          => 'Tipe gaji wajib dipilih.',

            'min_price.required_if'         => 'Gaji minimum wajib diisi.',
            'max_price.required_if'         => 'Gaji maksimum wajib diisi.',


            /*
            |--------------------------------------------------------------------------
            | USIA
            |--------------------------------------------------------------------------
            */

            'min_age.integer'               => 'Usia minimum harus berupa angka.',
            'max_age.integer'               => 'Usia maksimum harus berupa angka.',
            'max_age.gte'                   => 'Usia maksimum tidak boleh lebih kecil dari usia minimum.',


            /*
            |--------------------------------------------------------------------------
            | TINGGI BADAN
            |--------------------------------------------------------------------------
            */

            'min_height.integer'            => 'Tinggi badan minimum harus berupa angka.',
            'min_height.min'                => 'Tinggi badan minimum tidak boleh kurang dari 100 cm.',
            'min_height.max'                => 'Tinggi badan minimum tidak boleh lebih dari 250 cm.',

            'max_height.integer'            => 'Tinggi badan maksimum harus berupa angka.',
            'max_height.min'                => 'Tinggi badan maksimum tidak boleh kurang dari 100 cm.',
            'max_height.max'                => 'Tinggi badan maksimum tidak boleh lebih dari 250 cm.',
            'max_height.gte'                => 'Tinggi badan maksimum tidak boleh lebih kecil dari tinggi badan minimum.',


            /*
            |--------------------------------------------------------------------------
            | BERAT BADAN
            |--------------------------------------------------------------------------
            */

            'min_weight.integer'            => 'Berat badan minimum harus berupa angka.',
            'min_weight.min'                => 'Berat badan minimum tidak boleh kurang dari 20 kg.',
            'min_weight.max'                => 'Berat badan minimum tidak boleh lebih dari 300 kg.',

            'max_weight.integer'            => 'Berat badan maksimum harus berupa angka.',
            'max_weight.min'                => 'Berat badan maksimum tidak boleh kurang dari 20 kg.',
            'max_weight.max'                => 'Berat badan maksimum tidak boleh lebih dari 300 kg.',
            'max_weight.gte'                => 'Berat badan maksimum tidak boleh lebih kecil dari berat badan minimum.',


            /*
            |--------------------------------------------------------------------------
            | PENGALAMAN
            |--------------------------------------------------------------------------
            */

            'min_experience.integer'        => 'Minimal pengalaman harus berupa angka.',

            'certificate.required' =>
                'Sertifikasi wajib dipilih.',

            'certificate.json' =>
                'Format sertifikasi tidak valid.',

            'competency_scheme.required' =>
                'Kompetensi skema wajib dipilih.',

            'competency_scheme.json' =>
                'Format kompetensi skema tidak valid.',

        ]);

        $validator->after(function ($validator) use ($request) {

            $certificate = json_decode(
                $request->certificate,
                true
            );

            if (
                !is_array($certificate) ||
                count($certificate) === 0
            ) {

                $validator->errors()->add(
                    'certificate',
                    'Minimal pilih satu sertifikasi.'
                );

            }


            $competencyScheme = json_decode(
                $request->competency_scheme,
                true
            );

            if (
                !is_array($competencyScheme) ||
                count($competencyScheme) === 0
            ) {

                $validator->errors()->add(
                    'competency_scheme',
                    'Minimal pilih satu kompetensi skema.'
                );

            }

        });

        if ($validator->fails()) {

            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors()
            ],422);

        }

        $job = JobVacancy::where('uuid', $id)->first();

        if(!$job){

            return response()->json([
                'status' => false,
                'message' => 'Lowongan tidak ditemukan.'
            ],404);

        }

        // keamanan agar BUJP / Company lain tidak bisa edit

        if(Auth::user()->role == 'bujp'){

            if($job->b_u_j_p_id != Auth::user()->user_bujp->bujp->id){

                return response()->json([
                    'status'=>false,
                    'message'=>'Anda tidak memiliki akses.'
                ],403);

            }

        }else{

            if($job->company_id != Auth::user()->user_company->company->id){

                return response()->json([
                    'status'=>false,
                    'message'=>'Anda tidak memiliki akses.'
                ],403);

            }

        }

        $province = Province::where('code',$request->province)->first();
        $city = City::where('code',$request->city)->first();
        $district = District::where('code',$request->district)->first();
        $village = Village::where('code',$request->village)->first();

        $isShowFee = $request->boolean('is_show_fee');

        $job->update([

            'position'           => $request->position,
            'description_work'   => $request->description_work,

            /*
            |--------------------------------------------------------------------------
            | RESPONSIBILITY
            |--------------------------------------------------------------------------
            | Dari hidden input dikirim dalam bentuk JSON
            */

            'responsibility'     => $request->responsibility,

            'facility'           => $request->facility,

            'kuota'              => $request->kuota,

            'status' => ($request->status === 'submitted')
            ? 'published'
            : ($request->status ?? $job->status),

            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,

            'province'           => $province?->name,
            'city'               => $city?->name,
            'district'           => $district?->name,
            'village'            => $village?->name,

            'address'            => $request->address,

            'working_type'       => $request->working_type,
            'working_system'     => $request->working_system,

            /*
            |--------------------------------------------------------------------------
            | GAJI
            |--------------------------------------------------------------------------
            */

            'is_show_fee'        => $isShowFee,

            'fee_type'           => $isShowFee
                                    ? $request->fee_type
                                    : 'monthly',

            'min_price'          => $isShowFee
                                    ? str_replace('.', '', $request->min_price)
                                    : null,

            'max_price'          => $isShowFee
                                    ? str_replace('.', '', $request->max_price)
                                    : null,

            /*
            |--------------------------------------------------------------------------
            | PERSYARATAN
            |--------------------------------------------------------------------------
            */

            'gender'             => $request->gender,

            'min_age'            => $request->min_age,
            'max_age'            => $request->max_age,

            'min_height'         => $request->min_height,
            'max_height'         => $request->max_height,

            'min_weight'         => $request->min_weight,
            'max_weight'         => $request->max_weight,

            'last_education'     => $request->last_education,

            'min_experience'     => $request->min_experience,

            'certificate'        => $request->certificate,

            'competency_scheme'        => $request->competency_scheme,

            'is_urgent'          => $request->boolean('is_urgent'),

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Lowongan berhasil diperbarui.'

        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = JobVacancy::where('uuid', $id)->first();
        
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function close($uuid)
    {
        $job = JobVacancy::where('uuid', $uuid)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CEK OWNER
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role == 'bujp') {

            abort_if(
                $job->b_u_j_p_id != Auth::user()->user_bujp->bujp->id,
                403
            );

        } else {

            abort_if(
                $job->company_id != Auth::user()->user_company->company->id,
                403
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        */

        if ($job->status != 'published') {

            return response()->json([

                'status' => false,

                'message' => 'Hanya lowongan yang sudah dipublikasikan yang dapat ditutup.'

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | TUTUP LOWONGAN
        |--------------------------------------------------------------------------
        */

        $job->update([

            'status' => 'closed'

        ]);


        /*
        |--------------------------------------------------------------------------
        | REJECT PELAMAR YANG MASIH APPLIED
        |--------------------------------------------------------------------------
        */

        JobApplication::where('job_vacancy_id', $job->id)
            ->where('status', 'applied')
            ->update([
                'status' => 'rejected'
            ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'message' => 'Lowongan berhasil ditutup dan pelamar yang masih dalam status applied otomatis ditolak.'

        ]);
    }

    public function withdraw($uuid)
    {
        $job = JobVacancy::where('uuid', $uuid)->firstOrFail();

        if(Auth::user()->role == 'bujp')
        {
            abort_if(
                $job->b_u_j_p_id != Auth::user()->user_bujp->bujp->id,
                403
            );
        }
        else
        {
            abort_if(
                $job->company_id != Auth::user()->user_company->company->id,
                403
            );
        }

        if($job->status != 'submitted')
        {
            return response()->json([

                'status' => false,

                'message' => 'Hanya lowongan yang sedang diajukan yang dapat ditarik.'

            ],422);
        }

        $job->update([

            'status' => 'draft'

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Pengajuan berhasil ditarik. Status lowongan kembali menjadi Draft.'

        ]);
    }
}
