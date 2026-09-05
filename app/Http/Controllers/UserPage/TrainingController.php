<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\TrainingApplication;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Security;
use Auth;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $security = Security::with([
            'badgeCertificate',
            'histories',
        ])->findOrFail(
            Auth::user()->user_security->security->id
        );

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
        $security = Security::with([
            'badgeCertificate',
            'histories',
        ])->findOrFail(
            Auth::user()->user_security->security->id
        );

        $securityId = $security->id;


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->get('search', '')
        );

        $provider = $request->get('provider');

        $type = $request->get('type');

        $location = $request->get('location');


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
                
            ]);


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        |
        | Hanya pelatihan yang aktif / tersedia.
        |
        */

        $query->where(
            'status',
            'published'
        );


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

        $query->latest('id');


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | Pagination hanya digunakan untuk infinite scroll.
        | Tidak akan ditampilkan sebagai pagination HTML.
        |
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
    
    public function show($uuid)
    {
        $data = Training::query()
            ->where('uuid', $uuid)
            ->where('status', 'published')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | HITUNG VIEW / CLICK
        |--------------------------------------------------------------------------
        */

        $data->increment('total_clicked');

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI
        |--------------------------------------------------------------------------
        */

        $data->quota = (int) ($data->quota ?? 0);

        $data->price = (int) ($data->price ?? 0);

        $data->duration_day = (int) ($data->duration_day ?? 0);

        /*
        |--------------------------------------------------------------------------
        | HITUNG JUMLAH PESERTA APPROVED
        |--------------------------------------------------------------------------
        */

        $registered = TrainingApplication::where('training_id', $data->id)
            ->where('status', 'approved')
            ->count();
        /*
        |--------------------------------------------------------------------------
        | CEK PENDAFTARAN USER
        |--------------------------------------------------------------------------
        */

        $security = Auth::user()
            ->user_security
            ->security;

        $application = TrainingApplication::where('training_id', $data->id)
            ->where('security_id', $security->id)
            ->whereIn('status', ['pending', 'approved'])
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

    public function myTraining()
    {
        $security = Auth::user()
            ->user_security
            ->security;

        $securityId = $security->id;


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $applications = TrainingApplication::query()
            ->where('security_id', $securityId)
            ->with('training');


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalTrainings = (clone $applications)->count();


        /*
        |--------------------------------------------------------------------------
        | BERLANGSUNG
        |--------------------------------------------------------------------------
        |
        | Training sedang running
        |
        */

        $totalOngoing = (clone $applications)
            ->whereHas('training', function ($query) {

                $query->where('status', 'running');

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | AKAN DATANG
        |--------------------------------------------------------------------------
        |
        | Training sudah published dan belum mulai
        |
        */

        $totalUpcoming = (clone $applications)
            ->whereHas('training', function ($query) {

                $query->where('status', 'published')
                    ->whereDate(
                        'start_date',
                        '>',
                        now()->toDateString()
                    );

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        |
        | Training sudah closed
        | ATAU tanggal selesai sudah lewat
        |
        */

        $totalCompleted = (clone $applications)
            ->whereHas('training', function ($query) {

                $query->where(function ($q) {

                    $q->where('status', 'closed')

                        ->orWhereDate(
                            'end_date',
                            '<',
                            now()->toDateString()
                        );

                });

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | DIBATALKAN
        |--------------------------------------------------------------------------
        */

        $totalCancelled = (clone $applications)
            ->whereHas('training', function ($query) {

                $query->where('status', 'cancelled');

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SERTIFIKAT
        |--------------------------------------------------------------------------
        |
        | Karena certificate ada di tabel trainings,
        | bukan training_applications.
        |
        */

        $totalCertificates = (clone $applications)
            ->whereHas('training', function ($query) {

                $query->where('is_certificate', 1);

            })
            ->whereHas('training', function ($query) {

                $query->where(function ($q) {

                    $q->where('status', 'closed')

                        ->orWhereDate(
                            'end_date',
                            '<',
                            now()->toDateString()
                        );

                });

            })
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

    public function myTrainingList(Request $request)
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
            'start_date',
        ];

        if (!in_array($sort, $allowedSort)) {
            $sort = 'latest';
        }


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = TrainingApplication::query()
            ->where(
                'security_id',
                $securityId
            )
            ->with('training');


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
                        function ($q) {

                            $q->where(
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
                        function ($q) {

                            $q->where(
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
                        function ($q) {

                            $q->where(function ($q) {

                                $q->where(
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
                        function ($q) {

                            $q->where(
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
                function ($q) use ($search) {

                    $q->where(function ($q) use ($search) {

                        $q->where(
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
