<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\SecurityHistory;
use App\Models\CleaningServiceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityHistoryController extends Controller
{
    /**
     * Mendapatkan profile berdasarkan role user.
     */
    private function getProfile()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return $user->user_security?->security;
        }

        if ($user->role === 'cs') {
            return $user->user_cleaning_service?->cleaning_service;
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Mendapatkan model history berdasarkan role.
     */
    private function getHistoryModel()
    {
        if (Auth::user()->role === 'satpam') {
            return SecurityHistory::class;
        }

        if (Auth::user()->role === 'cs') {
            return CleaningServiceHistory::class;
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Mendapatkan category berdasarkan role.
     */
    private function getCategory()
    {
        if (Auth::user()->role === 'satpam') {
            return 'security';
        }

        if (Auth::user()->role === 'cs') {
            return 'cs';
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Mendapatkan nama foreign key berdasarkan role.
     */
    private function getOwnerColumn()
    {
        if (Auth::user()->role === 'satpam') {
            return 'security_id';
        }

        if (Auth::user()->role === 'cs') {
            return 'cleaning_service_id';
        }

        abort(403, 'Role tidak valid.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }

        $model = $this->getHistoryModel();
        $ownerColumn = $this->getOwnerColumn();

        $histories = $model::where($ownerColumn, $profile->id)
            ->orderByDesc('start_date')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $histories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'status' => true,
            'category' => $this->getCategory(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|max:255',
            'company_name' => 'required|max:255',
            'location' => 'required|max:255',
            'category' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable',
            'description' => 'nullable',
        ]);

        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }

        $model = $this->getHistoryModel();

        $history = new $model();

        if (Auth::user()->role === 'satpam') {
            $history->security_id = $profile->id;
        } else {
            $history->cleaning_service_id = $profile->id;
        }

        $history->position = $request->position;
        $history->company_name = $request->company_name;
        $history->location = $request->location;

        $history->category = $request->category;

        $history->start_date = $request->start_date;
        $history->end_date = $request->end_date;
        $history->is_current = $request->is_current ? 1 : 0;
        $history->description = $request->description;

        $history->save();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat berhasil ditambahkan.',
            'data' => $history,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }

        $model = $this->getHistoryModel();
        $ownerColumn = $this->getOwnerColumn();

        $history = $model::where('uuid', $uuid)
            ->where($ownerColumn, $profile->id)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $history,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }

        $model = $this->getHistoryModel();
        $ownerColumn = $this->getOwnerColumn();

        $history = $model::where('uuid', $uuid)
            ->where($ownerColumn, $profile->id)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $history,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'position' => 'required|max:255',
            'company_name' => 'required|max:255',
            'location' => 'required|max:255',
            'category' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable',
            'description' => 'nullable',
        ]);

        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }

        $model = $this->getHistoryModel();
        $ownerColumn = $this->getOwnerColumn();

        $history = $model::where('uuid', $request->uuid)
            ->where($ownerColumn, $profile->id)
            ->firstOrFail();

        $history->update([
            'position' => $request->position,
            'company_name' => $request->company_name,
            'location' => $request->location,

            // Category tidak mengikuti input frontend.
            // Selalu mengikuti role user.
            'category' => $request->category,

            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => $request->is_current ? 1 : 0,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Riwayat berhasil diperbarui.',
            'data' => $history->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }

        $model = $this->getHistoryModel();
        $ownerColumn = $this->getOwnerColumn();

        $history = $model::where('uuid', $uuid)
            ->where($ownerColumn, $profile->id)
            ->firstOrFail();

        $history->delete();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat penugasan berhasil dihapus.',
        ]);
    }
}