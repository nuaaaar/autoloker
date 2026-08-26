<?php

namespace App\Http\Controllers\Admin;

use App\Models\MasterCategoryCertificate;
use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterCategoryCertificateController extends Controller
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
            $data = MasterCategoryCertificate::when($searchValue, function($q) use($searchValue) {
                $q->orWhere('title', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.master.category-certificate.index');
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
        $request->validate([
            'title' => 'required|max:255|unique:master_category_certificates,title'
        ]);

        MasterCategoryCertificate::create([
            'title' => $request->title
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title' => 'required|max:255|unique:master_category_certificates,title,' . $uuid . ',uuid'
        ]);

        $data = MasterCategoryCertificate::where('uuid',$uuid)->firstOrFail();

        $data->update([
            'title'=>$request->title
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Data berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = MasterCategoryCertificate::where('uuid', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
