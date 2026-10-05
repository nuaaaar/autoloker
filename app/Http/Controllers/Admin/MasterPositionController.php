<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use App\Models\MasterPosition;
use Illuminate\Http\Request;

class MasterPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category)
    {
        abort_unless(
            in_array($category, ['cs', 'security']),
            404
        );

        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            $orderColumn = $request->input('order.0.column') ?? 0;

            $orderSort = $request->input('order.0.dir') ?? 'asc';

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data'
            ) ?? 'id';

            $data = MasterPosition::where('category', $category)

                ->when($searchValue, function ($q) use ($searchValue) {
                    $q->where('title', 'like', '%' . $searchValue . '%');
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

        return view(
            'dashboard-admin.master.position.index',
            compact('category')
        );
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
    public function store(Request $request, $category)
    {
        abort_unless(
            in_array($category, ['cs', 'security']),
            404
        );

        $request->validate([
            'title' => 'required|max:255|unique:master_positions,title'
        ]);

        MasterPosition::create([
            'title' => $request->title,
            'category' => $category,
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
    public function update(Request $request, $category, $uuid)
    {
        abort_unless(
            in_array($category, ['cs', 'security']),
            404
        );

        $data = MasterPosition::where('uuid', $uuid)
            ->where('category', $category)
            ->firstOrFail();

        $request->validate([
            'title' => 'required|max:255|unique:master_positions,title,' . $uuid . ',uuid'
        ]);

        $data->update([
            'title' => $request->title
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category, $uuid)
    {
        abort_unless(
            in_array($category, ['cs', 'security']),
            404
        );

        $data = MasterPosition::where('uuid', $uuid)
            ->where('category', $category)
            ->first();

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
