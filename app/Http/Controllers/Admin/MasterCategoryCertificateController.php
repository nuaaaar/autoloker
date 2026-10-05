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

        return view(
            'dashboard-admin.master.category-certificate.index',
            compact('category')
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(
        Request $request,
        $category
    ) {
        $this->validateCategory($category);

        $request->validate([
            'title' => [
                'required',
                'max:255',

                Rule::unique(
                    'master_category_certificates',
                    'title'
                )->where(function ($query) use ($category) {

                    return $query->where(
                        'category',
                        $category
                    );

                }),
            ],
        ]);

        MasterCategoryCertificate::create([
            'title' => $request->title,
            'category' => $category,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
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
            ->firstOrFail();

        $request->validate([
            'title' => [
                'required',
                'max:255',

                Rule::unique(
                    'master_category_certificates',
                    'title'
                )
                ->where(function ($query) use ($category) {

                    return $query->where(
                        'category',
                        $category
                    );

                })
                ->ignore(
                    $uuid,
                    'uuid'
                ),
            ],
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