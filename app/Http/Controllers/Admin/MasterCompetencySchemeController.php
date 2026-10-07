<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\MasterCompetencyScheme;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterCompetencySchemeController extends Controller
{
    /**
     * Category yang diperbolehkan.
     */
    private array $categories = [
        'security',
        'cs',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category)
    {
        $this->validateCategory($category);

        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            $orderColumn = $request->input('order.0.column') ?? 0;
            $orderSort   = $request->input('order.0.dir') ?? 'asc';
            $orderValue  = $request->input(
                'columns.' . $orderColumn . '.data'
            ) ?? 'id';

            /*
             * Kolom yang boleh digunakan untuk sorting.
             * Mencegah user memasukkan nama kolom sembarangan.
             */
            $allowedOrderColumns = [
                'id',
                'title',
                'category',
            ];

            if (!in_array($orderValue, $allowedOrderColumns)) {
                $orderValue = 'id';
            }

            $data = MasterCompetencyScheme::query()
                ->where('category', $category)

                ->when($searchValue, function ($q) use ($searchValue) {
                    $q->where(function ($query) use ($searchValue) {
                        $query->where(
                            'title',
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

        return view(
            'dashboard-admin.master.competency-scheme.index',
            compact('category')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $category)
    {
        $this->validateCategory($category);

        $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('master_competency_schemes', 'title')
                    ->where(function ($query) use ($category) {
                        return $query->where('category', $category);
                    }),
            ],
        ]);

        MasterCompetencyScheme::create([
            'title'    => $request->title,
            'category' => $category,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil ditambahkan.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($category, $uuid)
    {
        $this->validateCategory($category);

        $data = MasterCompetencyScheme::where('category', $category)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $category, $uuid)
    {
        $this->validateCategory($category);

        $data = MasterCompetencyScheme::where('category', $category)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('master_competency_schemes', 'title')
                    ->where(function ($query) use ($category) {
                        return $query->where('category', $category);
                    })
                    ->ignore($data->id),
            ],
        ]);

        $data->update([
            'title' => $request->title,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diperbarui.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category, $uuid)
    {
        $this->validateCategory($category);

        $data = MasterCompetencyScheme::where('category', $category)
            ->where('uuid', $uuid)
            ->first();

        if (!$data) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }

    /**
     * Validasi category.
     */
    private function validateCategory($category)
    {
        abort_unless(
            in_array($category, $this->categories),
            404
        );
    }
}