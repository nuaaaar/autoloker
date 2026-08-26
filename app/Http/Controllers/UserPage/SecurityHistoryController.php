<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\SecurityHistory;
use Illuminate\Http\Request;
use Auth;

class SecurityHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'position'=>'required',
            'company_name'=>'required',
            'location'=>'required',
            'category'=>'required',
            'start_date'=>'required|date',
            'end_date'=>'nullable',
            'description'=>'nullable'
        ]);

        $history = SecurityHistory::create([
            'security_id' => Auth::user()->user_security->security->id,

            'position' => $request->position,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'category' => $request->category,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => $request->is_current ? 1 : 0,

            'description' => $request->description
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Riwayat berhasil ditambahkan.',
            'data'=>$history
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SecurityHistory $securityHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecurityHistory $securityHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $history = SecurityHistory::where('uuid',$request->uuid)->firstOrFail();

        $history->update([
            'position'=>$request->position,
            'company_name'=>$request->company_name,
            'location'=>$request->location,
            'category'=>$request->category,

            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'is_current'=>$request->is_current ? 1 : 0,

            'description'=>$request->description
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Riwayat berhasil diperbarui.',
            'data'=>$history
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $history = SecurityHistory::where('uuid',$uuid)->firstOrFail();

        $history->delete();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat penugasan berhasil dihapus.'
        ]);
    }
}
