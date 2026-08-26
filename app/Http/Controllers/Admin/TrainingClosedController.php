<?php

namespace App\Http\Controllers\Admin;

use App\Models\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;

class TrainingClosedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column') ?? 0;
            $orderSort   = $request->input('order.0.dir') ?? 'asc';
            $orderValue  = $request->input('columns.' . $orderColumn . '.data') ?? 'id';

            $data = Training::with('bujp', 'company')->where('status', 'closed')
            ->when($searchValue, function ($q) use ($searchValue) {

                $q->where(function ($query) use ($searchValue) {

                    // Pelatihan
                    $query->orWhere('title', 'like', "%{$searchValue}%");

                    // Penyelenggara
                    $query->orWhere('provider', 'like', "%{$searchValue}%");

                    // Mode
                    $query->orWhere('training_mode', 'like', "%{$searchValue}%");

                    // Lokasi
                    $query->orWhere('province', 'like', "%{$searchValue}%");
                    $query->orWhere('city', 'like', "%{$searchValue}%");
                    $query->orWhere('district', 'like', "%{$searchValue}%");
                    $query->orWhere('village', 'like', "%{$searchValue}%");
                    $query->orWhere('address', 'like', "%{$searchValue}%");

                    // Periode
                    $query->orWhere('start_date', 'like', "%{$searchValue}%");
                    $query->orWhere('end_date', 'like', "%{$searchValue}%");

                    // Status
                    $query->orWhere('status', 'like', "%{$searchValue}%");

                });

            })
            ->orderBy($orderValue, $orderSort)
            ->paginate($request->length ?? 10);

            return new MasterResource(true, '00', 'List Data', $data);

        }

        return view('dashboard-admin.training.closed.index');
    }
}
