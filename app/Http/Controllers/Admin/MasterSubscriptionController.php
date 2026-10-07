<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\MasterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MasterSubscriptionController extends Controller
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
            | ALLOWED SORT COLUMN
            |--------------------------------------------------------------------------
            */

            $allowedSort = [
                'id',
                'name',
                'role',
                'price',
                'duration',
                'duration_type',
                'is_active',
                'sort_order',
                'created_at',
            ];

            if (!in_array($orderValue, $allowedSort)) {
                $orderValue = 'id';
            }

            if (!in_array($orderSort, ['asc', 'desc'])) {
                $orderSort = 'asc';
            }

            /*
            |--------------------------------------------------------------------------
            | QUERY
            |--------------------------------------------------------------------------
            */

            $data = MasterSubscription::query()

                ->when($searchValue, function ($q) use ($searchValue) {

                    $q->where(function ($query) use ($searchValue) {

                        $query
                            ->where('name', 'like', '%' . $searchValue . '%')
                            ->orWhere('role', 'like', '%' . $searchValue . '%')
                            ->orWhere(
                                'duration_type',
                                'like',
                                '%' . $searchValue . '%'
                            );

                    });

                })

                ->orderBy($orderValue, $orderSort)

                ->paginate(
                    $request->length ?? 10
                );

            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );
        }

        return view(
            'dashboard-admin.master.subscription.index'
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FEATURES
        |--------------------------------------------------------------------------
        */

        $features = null;

        if ($request->filled('features')) {

            $decodedFeatures = json_decode(
                $request->features,
                true
            );

            if (json_last_error() !== JSON_ERROR_NONE) {

                return response()->json([
                    'status' => false,
                    'message' => 'Format Features harus berupa JSON yang valid.'
                ], 422);

            }

            $features = json_encode(
                $decodedFeatures
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        MasterSubscription::create([

            'uuid' => (string) Str::uuid(),

            'name' => $request->name,

            'slug' => Str::slug(
                $request->name
            ),

            'role' => $request->role,

            'price' => $request->price,

            'duration' => $request->duration,

            'duration_type' => $request->duration_type,

            'description' => $request->description,

            'features' => $features,

            'is_active' => $request->has('is_active')
                ? (bool) $request->is_active
                : true,

            'is_highlight' => $request->has('is_highlight')
                ? (bool) $request->is_highlight
                : true,

            'sort_order' => $request->sort_order ?? 0,

        ]);


        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan.'
        ]);
    }


    public function update(Request $request, $uuid)
    {
        $data = MasterSubscription::where('uuid', $uuid)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | FEATURES
        |--------------------------------------------------------------------------
        */

        $features = null;

        if ($request->filled('features')) {

            $features = json_decode(
                $request->features,
                true
            );

            if (json_last_error() !== JSON_ERROR_NONE) {

                return response()->json([
                    'status' => false,
                    'message' => 'Format Features harus berupa JSON yang valid.',
                ], 422);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $data->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'role' => $request->role,
            'price' => $request->price,
            'duration' => $request->duration,
            'duration_type' => $request->duration_type,
            'description' => $request->description,
            'features' => $features,
            'is_active' => $request->is_active,
            'is_highlight' => $request->is_highlight,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $data = MasterSubscription::where(
            'uuid',
            $uuid
        )->first();


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