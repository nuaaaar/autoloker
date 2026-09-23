<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\Partner;
use App\Models\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | AJAX DATATABLE
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            $searchValue = $request->input('search.value');

            /*
            |--------------------------------------------------------------------------
            | ORDER
            |--------------------------------------------------------------------------
            */

            $orderColumn = $request->input('order.0.column', 0);

            $orderSort = $request->input(
                'order.0.dir',
                'asc'
            );

            $orderValue = $request->input(
                'columns.' . $orderColumn . '.data',
                'id'
            );

            /*
            |--------------------------------------------------------------------------
            | ALLOWED ORDER COLUMN
            |--------------------------------------------------------------------------
            |
            | Sesuaikan dengan kolom yang memang ada di tabel.
            |
            */

            $allowedOrder = [
                'id',
                'name',
                'address',
                'phone',
                'is_active',
                'created_at',
            ];

            if (!in_array($orderValue, $allowedOrder)) {
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

            $data = Partner::query()

                ->when($searchValue, function ($query) use ($searchValue) {

                    $query->where(function ($q) use ($searchValue) {

                        $q->where(
                            'name',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        ->orWhere(
                            'address',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        ->orWhere(
                            'description',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        ->orWhere(
                            'phone',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        ->orWhere(
                            'website',
                            'like',
                            '%' . $searchValue . '%'
                        );

                    });

                })

                ->orderBy(
                    $orderValue,
                    $orderSort
                )

                ->paginate(
                    $request->input('length', 10)
                );

            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return new MasterResource(
                true,
                '00',
                'List Data',
                $data
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-admin.management-user.partner.index'
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'status' => true,
            'message' => 'Form create partner.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'address' => [
                'nullable',
                'string'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'website' => [
                'nullable',
                'string',
                'max:255'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD LOGO
        |--------------------------------------------------------------------------
        */

        $logo = null;

        if ($request->hasFile('logo')) {

            $logo = $request
                ->file('logo')
                ->store(
                    'partners',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE DATA
        |--------------------------------------------------------------------------
        */

        $partner = Partner::create([

            'name' => $request->input('name'),

            'logo' => $logo,

            'address' => $request->input('address'),

            'description' => $request->input('description'),

            'website' => $request->input('website'),

            'phone' => $request->input('phone'),

            'is_active' => $request->boolean('is_active'),

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil ditambahkan.',

            'data' => $partner

        ]);
    }

    /**
     * Display partner detail.
     */
    public function show($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | PARTNER
        |--------------------------------------------------------------------------
        */

        $partner = Partner::where('uuid', $uuid)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | SECURITY YANG TERHUBUNG DENGAN PARTNER
        |--------------------------------------------------------------------------
        |
        | security_partners.user_id
        |       ↓
        | users.id
        |       ↓
        | user_securities.user_id
        |       ↓
        | securities.user_security_id
        |
        |--------------------------------------------------------------------------
        */

        $securityIds = DB::table('security_partners')
            ->join(
                'user_securities',
                'user_securities.user_id',
                '=',
                'security_partners.user_id'
            )
            ->join(
                'securities',
                'securities.user_security_id',
                '=',
                'user_securities.id'
            )
            ->where('security_partners.partner_id', $partner->id)
            ->pluck('securities.id');


        /*
        |--------------------------------------------------------------------------
        | TOTAL SECURITY
        |--------------------------------------------------------------------------
        */

        $totalSecurity = $securityIds->count();


        /*
        |--------------------------------------------------------------------------
        | SECURITY LIST
        |--------------------------------------------------------------------------
        */

        $securities = Security::with([
            'badgeCertificate',
            'histories'
        ])
            ->whereIn('id', $securityIds)
            ->orderBy('name', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-admin.management-user.partner.show',
            compact(
                'partner',
                'securities',
                'totalSecurity'
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND DATA BY UUID
        |--------------------------------------------------------------------------
        */

        $partner = Partner::where(
            'uuid',
            $uuid
        )->first();

        if (!$partner) {

            return response()->json([

                'status' => false,

                'message' => 'Data mitra tidak ditemukan.'

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        |
        | Blade:
        |
        | success: function(res) {
        |     let data = res.data;
        | }
        |
        */

        return response()->json([

            'status' => true,

            'message' => 'Data mitra ditemukan.',

            'data' => [

                'id' => $partner->id,

                'uuid' => $partner->uuid,

                'name' => $partner->name,

                'logo' => $partner->logo,

                'address' => $partner->address,

                'description' => $partner->description,

                'website' => $partner->website,

                'phone' => $partner->phone,

                'is_active' => (bool) $partner->is_active,

            ]

        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'address' => [
                'nullable',
                'string'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'website' => [
                'nullable',
                'string',
                'max:255'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | FIND DATA
        |--------------------------------------------------------------------------
        */

        $partner = Partner::where(
            'uuid',
            $uuid
        )->first();

        if (!$partner) {

            return response()->json([

                'status' => false,

                'message' => 'Data mitra tidak ditemukan.'

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | CURRENT LOGO
        |--------------------------------------------------------------------------
        */

        $logo = $partner->logo;


        /*
        |--------------------------------------------------------------------------
        | UPLOAD NEW LOGO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            /*
            |--------------------------------------------------------------------------
            | DELETE OLD LOGO
            |--------------------------------------------------------------------------
            */

            if (
                $partner->logo &&
                Storage::disk('public')->exists(
                    $partner->logo
                )
            ) {

                Storage::disk('public')->delete(
                    $partner->logo
                );
            }


            /*
            |--------------------------------------------------------------------------
            | STORE NEW LOGO
            |--------------------------------------------------------------------------
            */

            $logo = $request
                ->file('logo')
                ->store(
                    'partners',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $partner->update([

            'name' => $request->input('name'),

            'logo' => $logo,

            'address' => $request->input('address'),

            'description' => $request->input('description'),

            'website' => $request->input('website'),

            'phone' => $request->input('phone'),

            'is_active' => $request->boolean('is_active'),

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil diperbarui.',

            'data' => $partner

        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND DATA
        |--------------------------------------------------------------------------
        */

        $partner = Partner::where(
            'uuid',
            $uuid
        )->first();

        if (!$partner) {

            return response()->json([

                'status' => false,

                'message' => 'Data mitra tidak ditemukan.'

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE LOGO
        |--------------------------------------------------------------------------
        */

        if (
            $partner->logo &&
            Storage::disk('public')->exists(
                $partner->logo
            )
        ) {

            Storage::disk('public')->delete(
                $partner->logo
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE DATABASE DATA
        |--------------------------------------------------------------------------
        */

        $partner->delete();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil dihapus.'

        ]);
    }
}