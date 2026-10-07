<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;

class JobVacancyRejectedController extends Controller
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

            $data = JobVacancy::with([
                    'bujp',
                    'company'
                ])
                ->where('status', 'rejected')

                ->when($searchValue, function ($q) use ($searchValue) {

                    $q->where(function ($query) use ($searchValue) {

                        $query->where(
                            'position',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        // Category
                        ->orWhere(
                            'category',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        // BUJP
                        ->orWhereHas('bujp', function ($query) use ($searchValue) {
                            $query->where(
                                'company_name',
                                'like',
                                '%' . $searchValue . '%'
                            );
                        })

                        // Company
                        ->orWhereHas('company', function ($query) use ($searchValue) {
                            $query->where(
                                'company_name',
                                'like',
                                '%' . $searchValue . '%'
                            );
                        })

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
                })

                ->orderBy($orderValue, $orderSort)

                ->paginate($request->length ?? 10);

            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );
        }

        return view('dashboard-admin.job-vacancy.rejected.index');
    }
}