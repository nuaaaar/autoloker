<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\MasterFAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterFAQController extends Controller
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

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data'
            ) ?? 'id';

            /*
            |--------------------------------------------------------------------------
            | WHITELIST ORDER COLUMN
            |--------------------------------------------------------------------------
            */

            $allowedColumns = [
                'id',
                'title',
                'description',
                'order',
                'created_at'
            ];

            if (!in_array($orderValue, $allowedColumns)) {
                $orderValue = 'order';
            }

            /*
            |--------------------------------------------------------------------------
            | GET DATA
            |--------------------------------------------------------------------------
            */

            $data = MasterFAQ::when($searchValue, function ($q) use ($searchValue) {

                $q->where(function ($query) use ($searchValue) {

                    $query->where(
                        'title',
                        'like',
                        '%' . $searchValue . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $searchValue . '%'
                    );

                });

            })
            ->orderBy($orderValue, $orderSort)
            ->paginate($request->length ?? 10);

            /*
            |--------------------------------------------------------------------------
            | RETURN API RESOURCE
            |--------------------------------------------------------------------------
            */

            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );
        }

        return view('dashboard-admin.master.faq.index');
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
            'title' => 'required|max:255',
            'description' => 'required',
            'order' => 'nullable|integer|min:1',
        ], [
            'title.required' => 'Pertanyaan wajib diisi.',
            'title.max' => 'Pertanyaan maksimal 255 karakter.',

            'description.required' => 'Jawaban wajib diisi.',

            'order.integer' => 'Urutan harus berupa angka.',
            'order.min' => 'Urutan minimal 1.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UUID
        |--------------------------------------------------------------------------
        */

        $uuid = Str::uuid();

        /*
        |--------------------------------------------------------------------------
        | ORDER
        |--------------------------------------------------------------------------
        */

        $order = $request->order;

        if (!$order) {
            $lastOrder = MasterFAQ::max('order');

            $order = $lastOrder
                ? $lastOrder + 1
                : 1;
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        MasterFAQ::create([
            'uuid' => $uuid,
            'title' => $request->title,
            'description' => $request->description,
            'order' => $order,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data FAQ berhasil ditambahkan.'
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
            'title' => 'required|max:255',
            'description' => 'required',
            'order' => 'nullable|integer|min:1',
        ], [
            'title.required' => 'Pertanyaan wajib diisi.',
            'title.max' => 'Pertanyaan maksimal 255 karakter.',

            'description.required' => 'Jawaban wajib diisi.',

            'order.integer' => 'Urutan harus berupa angka.',
            'order.min' => 'Urutan minimal 1.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | FIND DATA
        |--------------------------------------------------------------------------
        */

        $data = MasterFAQ::where('uuid', $uuid)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | ORDER
        |--------------------------------------------------------------------------
        */

        $order = $request->order;

        if (!$order) {
            $order = $data->order;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $data->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $order,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data FAQ berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = MasterFAQ::where('uuid', $id)->first();

        if (!$data) {

            return response()->json([
                'status' => false,
                'message' => 'Data FAQ tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data FAQ berhasil dihapus.'
        ]);
    }
}