<?php

namespace App\Http\Controllers\Admin;

use App\Models\BUJP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;

class BUJPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->input('search.value');
            $orderColumn = $request->input('order.0.column') ?? 0;
            $orderSort = $request->input('order.0.dir') ?? 'asc';
            $orderValue  = $request->input('columns.' . $orderColumn . '.data') ?? 'id';
            //get data
            $data = BUJP::when($searchValue, function($q) use($searchValue) {
                $q->orWhere('company_name', 'like', '%' . $searchValue . '%');
                $q->orWhere('email', 'like', '%' . $searchValue . '%');
                $q->orWhere('npwp', 'like', '%' . $searchValue . '%');
                $q->orWhere('nib', 'like', '%' . $searchValue . '%');
                $q->orWhere('business_license', 'like', '%' . $searchValue . '%');
                $q->orWhere('sio_number', 'like', '%' . $searchValue . '%');
                $q->orWhere('sio_expired_date', 'like', '%' . $searchValue . '%');
                $q->orWhere('phone', 'like', '%' . $searchValue . '%');
                $q->orWhere('is_verified', 'like', '%' . $searchValue . '%');
                $q->orWhere('is_active', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.management-user.bujp.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['profile'] = BUJP::where('uuid', $id)->firstOrFail();

        $data['profileProgress'] = $data['profile']->profileProgress();

        return view('dashboard-admin.management-user.bujp.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function verify($uuid)
    {

        $company = BUJP::where('uuid',$uuid)->firstOrFail();

        if($company->is_verified){

            return response()->json([

                'status'=>false,

                'message'=>'Perusahaan sudah diverifikasi.'

            ],422);

        }

        $company->update([

            'is_verified'=>1

        ]);

        return response()->json([

            'status'=>true,

            'message'=>'Perusahaan berhasil diverifikasi.'

        ]);

    }

    public function changeStatus(Request $request, $uuid)
    {
        $request->validate([
            'status' => ['required', 'boolean']
        ]);

        $company = BUJP::where('uuid', $uuid)->firstOrFail();

        $company->update([
            'is_active' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => $request->status
                ? 'Perusahaan berhasil diaktifkan.'
                : 'Perusahaan berhasil dinonaktifkan.'
        ]);
    }
}
