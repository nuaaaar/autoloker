<?php

namespace App\Http\Controllers\Admin;

use App\Models\MasterCategoryCertificate;
use App\Http\Resources\MasterResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterCategoryCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category)
    {
        $this->validateCategory($category);

        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            $orderColumn = $request->input('order.0.column') ?? 0;

            $orderSort = $request->input('order.0.dir') ?? 'asc';

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data'
            ) ?? 'id';

            $data = MasterCategoryCertificate::where(
                    'category',
                    $category
                )
                ->when($searchValue, function ($q) use ($searchValue) {

                    $q->where(
                        'title',
                        'like',
                        '%' . $searchValue . '%'
                    );

                })
                ->orderBy(
                    $orderValue,
                    $orderSort
                )
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

        $parentCertificates = MasterCategoryCertificate::where('category', $category)
        ->orderBy('level')
        ->orderBy('title')
        ->get(['id', 'title', 'level', 'is_tuk']);

        return view(
            'dashboard-admin.master.category-certificate.index',
            compact('category', 'parentCertificates')
        );
    }


    public function store(Request $request, $category)
    {
        $this->validateCategory($category);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('master_category_certificates', 'title')
                    ->where(function ($query) use ($category) {
                        return $query->where('category', $category);
                    }),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('master_category_certificates', 'id')
                    ->where(function ($query) use ($category) {
                        return $query->where('category', $category);
                    }),
            ],
            'is_tuk' => [
                'nullable',
                'boolean',
            ],
        ]);
        $parentId = $validated['parent_id'] ?? null;

        $parent = $parentId === null
            ? null
            : MasterCategoryCertificate::withTrashed()
                ->where('category', $category)
                ->findOrFail($parentId);
        $level = $parent === null ? 1 : (int) $parent->level + 1;

        $saved = MasterCategoryCertificate::create([
            'title'     => $validated['title'],
            'category'  => $category,
            'parent_id' => $parentId,
            'is_tuk'    => (bool) $parent?->is_tuk || $request->boolean('is_tuk'),
            'level'     => $level,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil ditambahkan.',
            'data' => [
                'id' => (int) $saved->id,
                'title' => $saved->title,
                'level' => (int) $saved->level,
                'is_tuk' => (bool) $saved->is_tuk,
            ],
        ]);




    }

    public function update(Request $request, $category, $uuid)
    {
        $this->validateCategory($category);

        $data = MasterCategoryCertificate::where('uuid', $uuid)
            ->where('category', $category)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('master_category_certificates', 'title')
                    ->where(function ($query) use ($category) {
                        return $query->where('category', $category);
                    })
                    ->ignore($uuid, 'uuid'),
            ],
            'parent_id' => [
                'nullable',
                Rule::exists('master_category_certificates', 'id')
                    ->where(function ($query) use ($category, $data) {
                        return $query
                            ->where('category', $category)
                            ->where('id', '!=', $data->id);
                    }),
            ],
            'is_tuk' => [
                'nullable',
                'boolean',
            ],
        ]);

        $parentId = $validated['parent_id'] ?? null;
        $parent = $parentId === null
            ? null
            : MasterCategoryCertificate::withTrashed()
                ->where('category', $category)
                ->findOrFail($parentId);
        $level = $parent === null ? 1 : (int) $parent->level + 1;

        $data->update([
            'title'     => $validated['title'],
            'parent_id' => $parentId,
            'is_tuk'    => (bool) $parent?->is_tuk || $request->boolean('is_tuk'),
            'level'     => $level,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diperbarui.',
            'data' => [
                'id' => (int) $data->id,
                'title' => $data->title,
                'level' => (int) $data->level,
                'is_tuk' => (bool) $data->is_tuk,
            ],
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(
        $category,
        $uuid
    ) {
        $this->validateCategory($category);

        $data = MasterCategoryCertificate::where(
                'uuid',
                $uuid
            )
            ->where(
                'category',
                $category
            )
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


    /**
     * Validate certificate category.
     */
    private function validateCategory($category)
    {
        abort_unless(
            in_array(
                $category,
                ['cs', 'security']
            ),
            404
        );
    }
}