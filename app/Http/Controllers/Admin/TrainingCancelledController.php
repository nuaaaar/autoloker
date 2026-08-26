<?php

namespace App\Http\Controllers\Admin;

use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;

class TrainingCancelledController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column') ?? 0;
            $orderSort   = $request->input('order.0.dir') ?? 'asc';
            $orderValue  = $request->input('columns.' . $orderColumn . '.data') ?? 'id';

            $data = Training::with('bujp', 'company')->where('status', 'cancelled')
            ->when($searchValue, function ($q) use ($searchValue) {

                $q->where(function ($query) use ($searchValue) {

                    $q->orWhereHas('bujp', function ($query) use ($searchValue) {
                        $query->where('company_name', 'like', '%' . $searchValue . '%');
                    });

                    $q->orWhereHas('company', function ($query) use ($searchValue) {
                        $query->where('company_name', 'like', '%' . $searchValue . '%');
                    });

                    $query->orWhere('title', 'like', "%{$searchValue}%");
                    $query->orWhere('provider', 'like', "%{$searchValue}%");
                    $query->orWhere('category', 'like', "%{$searchValue}%");
                    $query->orWhere('level', 'like', "%{$searchValue}%");
                    $query->orWhere('province', 'like', "%{$searchValue}%");
                    $query->orWhere('city', 'like', "%{$searchValue}%");
                    $query->orWhere('training_mode', 'like', "%{$searchValue}%");
                    $query->orWhere('certificate_name', 'like', "%{$searchValue}%");
                    $query->orWhere('status', 'like', "%{$searchValue}%");

                });

            })
            ->orderBy($orderValue, $orderSort)
            ->paginate($request->length ?? 10);

            return new MasterResource(true, '00', 'List Data', $data);

        }

        return view('dashboard-admin.training.cancelled.index');
    }
}
