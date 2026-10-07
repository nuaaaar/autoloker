<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\TrainingApplication;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Security;
use App\Models\CleaningService;
use Auth;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HELPER PROFILE
    |--------------------------------------------------------------------------
    |
    | Variable tetap menggunakan nama $security.
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
    | CATEGORY ROLE TRAINING
    |--------------------------------------------------------------------------
    |
    | satpam -> security
    | cs     -> cs
    |
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


    /*
    |--------------------------------------------------------------------------
    | OWNER COLUMN TRAINING APPLICATION
    |--------------------------------------------------------------------------
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


        $security->load([
            'badgeCertificate',
            'histories',
        ]);


        return view(
            'user-page.training.index',
            compact('security')
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

        $securityId = $security->id;

        $categoryRole = $this->getCategoryRole();

        $ownerColumn = $this->getOwnerColumn();


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

        $provider = $request->get(
            'provider'
        );

        $type = $request->get(
            'type'
        );

        $location = $request->get(
            'location'
        );


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Training::query()

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            ->with([
                // Sesuaikan dengan relasi model Anda
            ])


            /*
            |--------------------------------------------------------------------------
            | CATEGORY ROLE
            |--------------------------------------------------------------------------
            */

            ->where(
                'category_role',
                $categoryRole
            )


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            ->where(
                'status',
                'published'
            )


            /*
            |--------------------------------------------------------------------------
            | DEADLINE TRAINING
            |--------------------------------------------------------------------------
            |
            | Jika end_date NULL -> masih tersedia.
            | Jika ada end_date -> belum lewat.
            |
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
                        'title',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'provider',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'description',
                        'LIKE',
                        "%{$search}%"
                    );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | PROVIDER
        |--------------------------------------------------------------------------
        */

        if ($provider) {

            $query->where(
                'provider_id',
                $provider
            );

        }


        /*
        |--------------------------------------------------------------------------
        | TYPE
        |--------------------------------------------------------------------------
        */

        if ($type) {

            $query->where(
                'type',
                $type
            );

        }


        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        if ($location) {

            $query->where(
                'location',
                'LIKE',
                "%{$location}%"
            );

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

        $trainings = $query
            ->paginate(1)
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
                    'user-page.training.partials.list',
                    compact('trainings')
                )->render(),

                'current_page' =>
                    $trainings->currentPage(),

                'last_page' =>
                    $trainings->lastPage(),

                'has_more' =>
                    $trainings->hasMorePages(),

                'total' =>
                    $trainings->total(),

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL RESPONSE
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.training.partials.list',
            compact('trainings')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($uuid)
    {
        $categoryRole = $this->getCategoryRole();

        $data = Training::query()

            ->where(
                'uuid',
                $uuid
            )

            /*
            |--------------------------------------------------------------------------
            | CATEGORY ROLE
            |--------------------------------------------------------------------------
            */

            ->where(
                'category_role',
                $categoryRole
            )

            ->where(
                'status',
                'published'
            )

            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | CEK END DATE
        |--------------------------------------------------------------------------
        */

        if (
            $data->end_date &&
            $data->end_date < now()->toDateString()
        ) {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG VIEW / CLICK
        |--------------------------------------------------------------------------
        */

        $data->increment(
            'total_clicked'
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI
        |--------------------------------------------------------------------------
        */

        $data->quota = (int) (
            $data->quota ?? 0
        );

        $data->price = (int) (
            $data->price ?? 0
        );

        $data->duration_day = (int) (
            $data->duration_day ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | HITUNG JUMLAH PESERTA APPROVED
        |--------------------------------------------------------------------------
        */

        $registered = TrainingApplication::query()

            ->where(
                'training_id',
                $data->id
            )

            ->where(
                'status',
                'approved'
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | CEK PENDAFTARAN USER
        |--------------------------------------------------------------------------
        */

        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $ownerColumn = $this->getOwnerColumn();


        $application = TrainingApplication::query()

            ->where(
                'training_id',
                $data->id
            )

            ->where(
                $ownerColumn,
                $securityId
            )

            ->whereIn(
                'status',
                [
                    'pending',
                    'approved',
                ]
            )

            ->first();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.training.show',
            compact(
                'data',
                'registered',
                'application'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MY TRAINING
    |--------------------------------------------------------------------------
    */

    public function myTraining()
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $categoryRole = $this->getCategoryRole();

        $ownerColumn = $this->getOwnerColumn();


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $applications = TrainingApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query->where(
                        'category_role',
                        $categoryRole
                    );

                }
            )

            ->with(
                'training'
            );


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalTrainings = (clone $applications)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | BERLANGSUNG
        |--------------------------------------------------------------------------
        */

        $totalOngoing = (clone $applications)

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(
                            'status',
                            'running'
                        );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | AKAN DATANG
        |--------------------------------------------------------------------------
        */

        $totalUpcoming = (clone $applications)

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(
                            'status',
                            'published'
                        )

                        ->whereDate(
                            'start_date',
                            '>',
                            now()->toDateString()
                        );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */

        $totalCompleted = (clone $applications)

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(function ($q) {

                            $q

                                ->where(
                                    'status',
                                    'closed'
                                )

                                ->orWhereDate(
                                    'end_date',
                                    '<',
                                    now()->toDateString()
                                );

                        });

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | DIBATALKAN
        |--------------------------------------------------------------------------
        */

        $totalCancelled = (clone $applications)

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(
                            'status',
                            'cancelled'
                        );

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | SERTIFIKAT
        |--------------------------------------------------------------------------
        */

        $totalCertificates = (clone $applications)

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(
                            'is_certificate',
                            1
                        );

                }
            )

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(function ($q) {

                            $q

                                ->where(
                                    'status',
                                    'closed'
                                )

                                ->orWhereDate(
                                    'end_date',
                                    '<',
                                    now()->toDateString()
                                );

                        });

                }
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.training.my',
            compact(
                'security',
                'totalTrainings',
                'totalOngoing',
                'totalUpcoming',
                'totalCompleted',
                'totalCancelled',
                'totalCertificates'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MY TRAINING LIST
    |--------------------------------------------------------------------------
    */

    public function myTrainingList(Request $request)
    {
        $security = $this->getProfile();

        if (!$security) {
            abort(403, 'Data profile belum tersedia.');
        }

        $securityId = $security->id;

        $categoryRole = $this->getCategoryRole();

        $ownerColumn = $this->getOwnerColumn();


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
            'start_date',
        ];

        if (!in_array(
            $sort,
            $allowedSort
        )) {

            $sort = 'latest';

        }


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = TrainingApplication::query()

            ->where(
                $ownerColumn,
                $securityId
            )

            /*
            |--------------------------------------------------------------------------
            | CATEGORY ROLE
            |--------------------------------------------------------------------------
            */

            ->whereHas(
                'training',
                function ($query) use ($categoryRole) {

                    $query->where(
                        'category_role',
                        $categoryRole
                    );

                }
            )

            ->with(
                'training'
            );


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($status) {

            switch ($status) {

                /*
                |--------------------------------------------------------------------------
                | BERLANGSUNG
                |--------------------------------------------------------------------------
                */

                case 'ongoing':

                    $query->whereHas(
                        'training',
                        function ($q) use ($categoryRole) {

                            $q

                                ->where(
                                    'category_role',
                                    $categoryRole
                                )

                                ->where(
                                    'status',
                                    'running'
                                );

                        }
                    );

                    break;


                /*
                |--------------------------------------------------------------------------
                | AKAN DATANG
                |--------------------------------------------------------------------------
                */

                case 'upcoming':

                    $query->whereHas(
                        'training',
                        function ($q) use ($categoryRole) {

                            $q

                                ->where(
                                    'category_role',
                                    $categoryRole
                                )

                                ->where(
                                    'status',
                                    'published'
                                )

                                ->whereDate(
                                    'start_date',
                                    '>',
                                    now()->toDateString()
                                );

                        }
                    );

                    break;


                /*
                |--------------------------------------------------------------------------
                | SELESAI
                |--------------------------------------------------------------------------
                */

                case 'completed':

                    $query->whereHas(
                        'training',
                        function ($q) use ($categoryRole) {

                            $q

                                ->where(
                                    'category_role',
                                    $categoryRole
                                )

                                ->where(function ($q) {

                                    $q

                                        ->where(
                                            'status',
                                            'closed'
                                        )

                                        ->orWhereDate(
                                            'end_date',
                                            '<',
                                            now()->toDateString()
                                        );

                                });

                        }
                    );

                    break;


                /*
                |--------------------------------------------------------------------------
                | DIBATALKAN
                |--------------------------------------------------------------------------
                */

                case 'cancelled':

                    $query->whereHas(
                        'training',
                        function ($q) use ($categoryRole) {

                            $q

                                ->where(
                                    'category_role',
                                    $categoryRole
                                )

                                ->where(
                                    'status',
                                    'cancelled'
                                );

                        }
                    );

                    break;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $query->whereHas(
                'training',
                function ($q) use ($search, $categoryRole) {

                    $q

                        ->where(
                            'category_role',
                            $categoryRole
                        )

                        ->where(function ($q) use ($search) {

                            $q

                                ->where(
                                    'title',
                                    'LIKE',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'provider',
                                    'LIKE',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'description',
                                    'LIKE',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'category',
                                    'LIKE',
                                    "%{$search}%"
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
            | TANGGAL MULAI
            |--------------------------------------------------------------------------
            */

            case 'start_date':

                $query

                    ->leftJoin(
                        'trainings',
                        'trainings.id',
                        '=',
                        'training_applications.training_id'
                    )

                    ->where(
                        'trainings.category_role',
                        $categoryRole
                    )

                    ->select(
                        'training_applications.*'
                    )

                    ->orderByRaw("
                        CASE
                            WHEN trainings.start_date IS NULL
                            THEN 1
                            ELSE 0
                        END ASC
                    ")

                    ->orderBy(
                        'trainings.start_date',
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
                    'user-page.training.partials.my-list',
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
            'user-page.training.partials.my-list',
            compact('applications')
        );
    }
}