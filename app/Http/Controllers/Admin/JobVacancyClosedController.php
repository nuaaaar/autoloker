<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;

class JobVacancyClosedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            $orderColumn =
                $request->input('order.0.column') ?? 0;

            $orderSort =
                $request->input('order.0.dir') ?? 'asc';

            $orderValue =
                $request->input(
                    'columns.' . $orderColumn . '.data'
                ) ?? 'id';


            /**
             * =========================================================
             * DATA
             * =========================================================
             */
            $data = JobVacancy::with([
                    'bujp',
                    'company'
                ])
                ->withCount([
                    'bookmarks',
                    'applications'
                ])

                ->where('status', 'closed')


                /**
                 * =====================================================
                 * SEARCH
                 * =====================================================
                 */
                ->when(
                    $searchValue,
                    function ($q) use ($searchValue) {

                        $q->where(function ($query) use ($searchValue) {

                            $query->where(
                                'position',
                                'like',
                                '%' . $searchValue . '%'
                            );


                            // CATEGORY
                            $query->orWhere(
                                'category',
                                'like',
                                '%' . $searchValue . '%'
                            );


                            // BUJP
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


                            // COMPANY
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


                            // PROVINCE
                            $query->orWhere(
                                'province',
                                'like',
                                '%' . $searchValue . '%'
                            );


                            // CITY
                            $query->orWhere(
                                'city',
                                'like',
                                '%' . $searchValue . '%'
                            );


                            // MIN FEE
                            $query->orWhere(
                                'min_fee',
                                'like',
                                '%' . $searchValue . '%'
                            );


                            // MAX FEE
                            $query->orWhere(
                                'max_fee',
                                'like',
                                '%' . $searchValue . '%'
                            );


                            // STATUS
                            $query->orWhere(
                                'status',
                                'like',
                                '%' . $searchValue . '%'
                            );

                        });

                    }
                )


                /**
                 * =====================================================
                 * SORTING
                 * =====================================================
                 */
                ->orderBy(
                    $orderValue,
                    $orderSort
                )


                /**
                 * =====================================================
                 * PAGINATION
                 * =====================================================
                 */
                ->paginate(
                    $request->length ?? 10
                );


            /**
             * =========================================================
             * RESPONSE
             * =========================================================
             */
            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );
        }


        return view(
            'dashboard-admin.job-vacancy.closed.index'
        );
    }
}