<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
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

        $data->registered = (int) ($data->registered ?? 0);

        $data->price = (int) ($data->price ?? 0);

        $data->duration_day = (int) ($data->duration_day ?? 0);

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.training.show',
            compact('data')
        );
    }
}
