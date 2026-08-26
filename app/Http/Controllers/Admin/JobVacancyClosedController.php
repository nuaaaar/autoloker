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
            $orderColumn = $request->input('order.0.column') ?? 0;
            $orderSort = $request->input('order.0.dir') ?? 'asc';
            $orderValue  = $request->input('columns.' . $orderColumn . '.data') ?? 'id';
            //get data
            $data = JobVacancy::with('bujp', 'company')->withCount(['bookmarks', 'applications'])
            ->where('status', 'closed')->when($searchValue, function($q) use($searchValue) {
                $q->orWhere('position', 'like', '%' . $searchValue . '%');

                $q->orWhereHas('bujp', function ($query) use ($searchValue) {
                    $query->where('company_name', 'like', '%' . $searchValue . '%');
                });

                $q->orWhereHas('company', function ($query) use ($searchValue) {
                    $query->where('company_name', 'like', '%' . $searchValue . '%');
                });
                $q->orWhere('province', 'like', '%' . $searchValue . '%');
                $q->orWhere('city', 'like', '%' . $searchValue . '%');
                $q->orWhere('min_fee', 'like', '%' . $searchValue . '%');
                $q->orWhere('max_fee', 'like', '%' . $searchValue . '%');
                $q->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.job-vacancy.closed.index');
    }
}
