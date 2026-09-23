<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\MasterNotification;
use Illuminate\Http\Request;

class MasterNotificationController extends Controller
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
            | SECURITY
            |--------------------------------------------------------------------------
            */

            $allowedOrder = [
                'id',
                'code',
                'name',
                'category',
                'is_active',
                'created_at'
            ];

            if (!in_array($orderValue, $allowedOrder)) {
                $orderValue = 'id';
            }


            /*
            |--------------------------------------------------------------------------
            | QUERY
            |--------------------------------------------------------------------------
            */

            $data = MasterNotification::query()

                ->when($searchValue, function ($q) use ($searchValue) {

                    $q->where(function ($query) use ($searchValue) {

                        $query->where(
                            'code',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        ->orWhere(
                            'name',
                            'like',
                            '%' . $searchValue . '%'
                        )

                        ->orWhere(
                            'category',
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
            'dashboard-admin.master.notification.index'
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
    public function store(Request $request)
    {
        $request->validate([

            'code' => [
                'required',
                'max:100',
                'regex:/^[A-Z0-9_]+$/',
                'unique:master_notifications,code'
            ],

            'name' => [
                'required',
                'max:255'
            ],

            'category' => [
                'required',
                'max:100'
            ],

            'description' => [
                'nullable'
            ],

            'title_template' => [
                'required',
                'max:255'
            ],

            'message_template' => [
                'required'
            ],

            'email_subject' => [
                'nullable',
                'max:255'
            ],

            'email_template' => [
                'nullable'
            ],

            'dashboard_route' => [
                'nullable',
                'max:255'
            ],

            'flutter_route' => [
                'nullable',
                'max:255'
            ],

            'web_enabled' => [
                'nullable',
                'boolean'
            ],

            'mobile_enabled' => [
                'nullable',
                'boolean'
            ],

            'email_enabled' => [
                'nullable',
                'boolean'
            ],

            'push_enabled' => [
                'nullable',
                'boolean'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],

        ]);


        MasterNotification::create([

            'code' => $request->code,

            'name' => $request->name,

            'category' => $request->category,

            'description' => $request->description,

            'title_template' => $request->title_template,

            'message_template' => $request->message_template,

            'email_subject' => $request->email_subject,

            'email_template' => $request->email_template,

            'dashboard_route' => $request->dashboard_route,

            'flutter_route' => $request->flutter_route,

            'web_enabled' => $request->boolean('web_enabled'),

            'mobile_enabled' => $request->boolean('mobile_enabled'),

            'email_enabled' => $request->boolean('email_enabled'),

            'push_enabled' => $request->boolean('push_enabled'),

            'is_active' => $request->boolean('is_active'),

        ]);


        return response()->json([

            'status' => true,

            'message' => 'Data berhasil ditambahkan.'

        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(MasterNotification $masterNotification)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterNotification $masterNotification)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([

            'code' => [
                'required',
                'max:100',
                'regex:/^[A-Z0-9_]+$/',
                'unique:master_notifications,code,' . $uuid . ',uuid'
            ],

            'name' => [
                'required',
                'max:255'
            ],

            'category' => [
                'required',
                'max:100'
            ],

            'description' => [
                'nullable'
            ],

            'title_template' => [
                'required',
                'max:255'
            ],

            'message_template' => [
                'required'
            ],

            'email_subject' => [
                'nullable',
                'max:255'
            ],

            'email_template' => [
                'nullable'
            ],

            'dashboard_route' => [
                'nullable',
                'max:255'
            ],

            'flutter_route' => [
                'nullable',
                'max:255'
            ],

            'web_enabled' => [
                'nullable',
                'boolean'
            ],

            'mobile_enabled' => [
                'nullable',
                'boolean'
            ],

            'email_enabled' => [
                'nullable',
                'boolean'
            ],

            'push_enabled' => [
                'nullable',
                'boolean'
            ],

            'is_active' => [
                'nullable',
                'boolean'
            ],

        ]);


        $data = MasterNotification::where(
            'uuid',
            $uuid
        )->firstOrFail();


        $data->update([

            'code' => $request->code,

            'name' => $request->name,

            'category' => $request->category,

            'description' => $request->description,

            'title_template' => $request->title_template,

            'message_template' => $request->message_template,

            'email_subject' => $request->email_subject,

            'email_template' => $request->email_template,

            'dashboard_route' => $request->dashboard_route,

            'flutter_route' => $request->flutter_route,

            'web_enabled' => $request->boolean('web_enabled'),

            'mobile_enabled' => $request->boolean('mobile_enabled'),

            'email_enabled' => $request->boolean('email_enabled'),

            'push_enabled' => $request->boolean('push_enabled'),

            'is_active' => $request->boolean('is_active'),

        ]);


        return response()->json([

            'status' => true,

            'message' => 'Data berhasil diperbarui.'

        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $data = MasterNotification::where(
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