<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use App\Models\MasterAbility;
use Illuminate\Http\Request;

class MasterAbilityController extends Controller
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
            $data = MasterAbility::when($searchValue, function($q) use($searchValue) {
                $q->orWhere('title', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.master.ability.index');
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
            'title' => 'required|max:255|unique:master_abilities,title'
        ]);

        MasterAbility::create([
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
    public function show(MasterAbility $masterAbility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterAbility $masterAbility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title' => 'required|max:255|unique:master_abilities,title,' . $uuid . ',uuid'
        ]);

        $data = MasterAbility::where('uuid',$uuid)->firstOrFail();

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
        $data = MasterAbility::where('uuid', $id)->first();

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
