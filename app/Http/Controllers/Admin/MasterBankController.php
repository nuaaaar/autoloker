<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\MasterBank;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterBankController extends Controller
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
            | Kolom yang diperbolehkan untuk sorting
            |--------------------------------------------------------------------------
            */

            $allowedColumns = [
                'id',
                'account_name',
                'bank_number',
                'bank_name',
            ];

            if (!in_array($orderValue, $allowedColumns)) {
                $orderValue = 'id';
            }

            if (!in_array(strtolower($orderSort), ['asc', 'desc'])) {
                $orderSort = 'asc';
            }

            /*
            |--------------------------------------------------------------------------
            | Query
            |--------------------------------------------------------------------------
            */

            $data = MasterBank::query()
                ->when($searchValue, function ($q) use ($searchValue) {

                    $q->where(function ($query) use ($searchValue) {

                        $query->where(
                            'account_name',
                            'like',
                            '%' . $searchValue . '%'
                        )
                        ->orWhere(
                            'bank_number',
                            'like',
                            '%' . $searchValue . '%'
                        )
                        ->orWhere(
                            'bank_name',
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

        return view('dashboard-admin.master.bank.index');
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
            'account_name' => 'required|string|max:255',
            'bank_number' => 'required|string|max:100',
            'bank_name' => 'required|string|max:255',
        ], [
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
            'bank_number.required' => 'Nomor rekening wajib diisi.',
            'bank_name.required' => 'Nama bank wajib diisi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cek duplikat
        |--------------------------------------------------------------------------
        */

        $exists = MasterBank::where('bank_number', $request->bank_number)
            ->where('bank_name', $request->bank_name)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Nomor rekening tersebut sudah terdaftar pada bank ini.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        MasterBank::create([
            'uuid' => (string) Str::uuid(),
            'account_name' => $request->account_name,
            'bank_number' => $request->bank_number,
            'bank_name' => $request->bank_name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data bank berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterBank $masterBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterBank $masterBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'bank_number' => 'required|string|max:100',
            'bank_name' => 'required|string|max:255',
        ], [
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
            'bank_number.required' => 'Nomor rekening wajib diisi.',
            'bank_name.required' => 'Nama bank wajib diisi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get data
        |--------------------------------------------------------------------------
        */

        $data = MasterBank::where('uuid', $uuid)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data bank tidak ditemukan.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek duplikat
        |--------------------------------------------------------------------------
        */

        $exists = MasterBank::where('bank_number', $request->bank_number)
            ->where('bank_name', $request->bank_name)
            ->where('id', '!=', $data->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Nomor rekening tersebut sudah terdaftar pada bank ini.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $data->update([
            'account_name' => $request->account_name,
            'bank_number' => $request->bank_number,
            'bank_name' => $request->bank_name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data bank berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $data = MasterBank::where('uuid', $uuid)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data bank tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data bank berhasil dihapus.'
        ]);
    }
}