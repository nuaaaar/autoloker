<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;

class JobVacancyPublishedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            $orderColumn = $request->input('order.0.column') ?? 0;

            $orderSort = $request->input('order.0.dir') ?? 'asc';

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data'
            ) ?? 'id';


            /*
            |--------------------------------------------------------------------------
            | DATA
            |--------------------------------------------------------------------------
            */

            $data = JobVacancy::with([
                    'bujp',
                    'company'
                ])
                ->withCount([
                    'applications',
                    'bookmarks'
                ])
                ->where('status', 'published')


                /*
                |--------------------------------------------------------------------------
                | SEARCH
                |--------------------------------------------------------------------------
                */

                ->when($searchValue, function ($q) use ($searchValue) {

                    $q->where(function ($query) use ($searchValue) {

                        $query->where(
                            'position',
                            'like',
                            '%' . $searchValue . '%'
                        );

                        $query->orWhere(
                            'category',
                            'like',
                            '%' . $searchValue . '%'
                        );

                        $query->orWhereHas(
                            'bujp',
                            function ($query) use ($searchValue) {

                                $query->where(
                                    'company_name',
                                    'like',
                                    '%' . $searchValue . '%'
                                );

                            }
                        );

                        $query->orWhereHas(
                            'company',
                            function ($query) use ($searchValue) {

                                $query->where(
                                    'company_name',
                                    'like',
                                    '%' . $searchValue . '%'
                                );

                            }
                        );

                        $query->orWhere(
                            'province',
                            'like',
                            '%' . $searchValue . '%'
                        );

                        $query->orWhere(
                            'city',
                            'like',
                            '%' . $searchValue . '%'
                        );

                        $query->orWhere(
                            'min_fee',
                            'like',
                            '%' . $searchValue . '%'
                        );

                        $query->orWhere(
                            'max_fee',
                            'like',
                            '%' . $searchValue . '%'
                        );

                        $query->orWhere(
                            'status',
                            'like',
                            '%' . $searchValue . '%'
                        );

                    });

                })


                /*
                |--------------------------------------------------------------------------
                | ORDER
                |--------------------------------------------------------------------------
                */

                ->orderBy(
                    $orderValue,
                    $orderSort
                )


                /*
                |--------------------------------------------------------------------------
                | PAGINATION
                |--------------------------------------------------------------------------
                */

                ->paginate(
                    $request->length ?? 10
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
            'dashboard-admin.job-vacancy.published.index'
        );
    }
}