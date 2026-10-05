<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MasterResource;
use App\Models\MasterPositionCleaningService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class MasterPositionCleaningServiceController extends Controller
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
            $data = MasterPositionCleaningService::when($searchValue, function($q) use($searchValue) {
                $q->orWhere('title', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.master.position-cleaning-service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => [
                'required',
                'string',
                'max:255',
                'unique:master_position_cleaning_services,title',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'responsibility' => [
                'nullable',
                'array',
            ],

            'responsibility.*' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ], [

            'title.required' => 'Nama jabatan cleaning service wajib diisi.',

            'title.unique' => 'Nama jabatan cleaning service sudah terdaftar.',

            'description.string' =>
                'Deskripsi harus berupa teks.',

            'responsibility.array' =>
                'Format tanggung jawab tidak valid.',

            'responsibility.*.string' =>
                'Tanggung jawab harus berupa teks.',

        ]);


        if ($validator->fails()) {

            return response()->json([

                'status' => false,

                'message' => $validator
                    ->errors()
                    ->first(),

                'errors' => $validator->errors(),

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIBILITY
        |--------------------------------------------------------------------------
        */

        $responsibility = collect(
            $request->input('responsibility', [])
        )
            ->map(function ($item) {

                return trim($item);

            })
            ->filter(function ($item) {

                return $item !== '';

            })
            ->values()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        MasterPositionCleaningService::create([

            'title' => trim($request->title),

            'description' =>
                $request->description,

            'responsibility' =>
                $responsibility,

        ]);


        return response()->json([

            'status' => true,

            'message' =>
                'Data berhasil ditambahkan.'

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $data = MasterPositionCleaningService::where(
            'uuid',
            $uuid
        )->firstOrFail();


        return response()->json([

            'status' => true,

            'data' => $data,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterPositionCleaningService $MasterPositionCleaningService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $position = MasterPositionCleaningService::where(
            'uuid',
            $uuid
        )->firstOrFail();


        $request->validate([

            'title' => [

                'required',

                'string',

                'max:255',

                Rule::unique(
                    'master_position_cleaning_services',
                    'title'
                )->ignore($position->id),

            ],

            'description' => [
                'nullable',
                'string',
            ],

            'responsibility' => [
                'nullable',
                'array',
            ],

            'responsibility.*' => [
                'nullable',
                'string',
                'max:500',
            ],

        ]);


        $responsibility = collect(
            $request->input('responsibility', [])
        )
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();


        $position->update([

            'title' =>
                $request->title,

            'description' =>
                $request->description,

            'responsibility' =>
                $responsibility,

        ]);


        return response()->json([

            'status' => true,

            'message' =>
                'Data berhasil diperbarui.'

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = MasterPositionCleaningService::where('uuid', $id)->first();

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
