<?php

namespace App\Http\Controllers\Admin;

use App\Models\Security;
use App\Models\CleaningService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Models\UserSecurity;
use App\Models\UserCleaningService;
use App\Models\User;

class SecurityController extends Controller
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
            $data = Security::with('user_security.user')->when($searchValue, function($q) use($searchValue) {
                $q->orWhere('name', 'like', '%' . $searchValue . '%');
                $q->orWhere('email', 'like', '%' . $searchValue . '%');
                $q->orWhere('birth_place', 'like', '%' . $searchValue . '%');
                $q->orWhere('birth_date', 'like', '%' . $searchValue . '%');
                $q->orWhere('gender', 'like', '%' . $searchValue . '%');
                $q->orWhere('province', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($orderValue, $orderSort)->paginate($request->length ?? 10);

            //return with Api Resource
            return new MasterResource(true, '00', 'List Data', $data);
        }

        return view('dashboard-admin.management-user.security.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with([
            'user_security.security.certificates',
            'user_security.security.histories',
            'user_cleaning_service.cleaning_service.certificates',
            'user_cleaning_service.cleaning_service.histories',
        ])
        ->where('uuid', $id)
        ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Ambil profile Security
        |--------------------------------------------------------------------------
        */

        $security = optional($user->user_security)->security;


        /*
        |--------------------------------------------------------------------------
        | Ambil profile Cleaning Service
        |--------------------------------------------------------------------------
        */

        $cleaningService = optional($user->user_cleaning_service)->cleaning_service;


        /*
        |--------------------------------------------------------------------------
        | Progress Profile
        |--------------------------------------------------------------------------
        */

        $profileProgressSecurity = $security
            ? $security->profileProgress()
            : ['progress' => 0];


        $profileProgressCleaningService = $cleaningService
            ? $cleaningService->profileProgress()
            : ['progress' => 0];


        return view(
            'dashboard-admin.management-user.security.show',
            compact(
                'user',
                'security',
                'cleaningService',
                'profileProgressSecurity',
                'profileProgressCleaningService'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Security $security)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Security $security)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Security $security)
    {
        //
    }

    public function changeStatus(Request $request, $uuid)
    {
        $request->validate([
            'status' => ['required', 'in:active,non-active']
        ]);

        $security = Security::where('uuid', $uuid)
            ->with('user_security.user')
            ->firstOrFail();

        $security->user_security->user->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status'  => true,
            'message' => $request->status == 'active'
                ? 'Akun satpam berhasil diaktifkan.'
                : 'Akun satpam berhasil dinonaktifkan.'
        ]);
    }
}
