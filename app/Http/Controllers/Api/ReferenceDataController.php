<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterAbility;
use App\Models\MasterCategoryCertificate;
use App\Models\MasterIndustry;
use App\Models\MasterPlacement;
use App\Models\MasterPosition;
use App\Models\MasterPositionSecurity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

class ReferenceDataController extends Controller
{
    public function positions(): JsonResponse
    {
        return $this->master(MasterPosition::query());
    }

    public function positionSecurities(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => MasterPositionSecurity::query()
                ->orderBy('title')
                ->get(['id', 'uuid', 'title', 'description', 'responsibility']),
        ]);
    }

    public function abilities(): JsonResponse
    {
        return $this->master(MasterAbility::query());
    }

    public function categoryCertificates(): JsonResponse
    {
        return $this->master(MasterCategoryCertificate::query());
    }

    public function placements(): JsonResponse
    {
        return $this->master(MasterPlacement::query());
    }

    public function industries(): JsonResponse
    {
        return $this->master(MasterIndustry::query());
    }

    public function provinces(): JsonResponse
    {
        return response()->json(['status' => true, 'data' => Province::query()->orderBy('name')->get(['code', 'name'])]);
    }

    public function cities(Request $request): JsonResponse
    {
        $request->validate(['province_code' => ['required', 'exists:'.(new Province)->getTable().',code']]);
        return response()->json(['status' => true, 'data' => City::where('province_code', $request->province_code)->orderBy('name')->get(['code', 'name'])]);
    }

    public function districts(Request $request): JsonResponse
    {
        $request->validate(['city_code' => ['required', 'exists:'.(new City)->getTable().',code']]);
        return response()->json(['status' => true, 'data' => District::where('city_code', $request->city_code)->orderBy('name')->get(['code', 'name'])]);
    }

    public function villages(Request $request): JsonResponse
    {
        $request->validate(['district_code' => ['required', 'exists:'.(new District)->getTable().',code']]);
        return response()->json(['status' => true, 'data' => Village::where('district_code', $request->district_code)->orderBy('name')->get(['code', 'name'])]);
    }

    private function master($query): JsonResponse
    {
        return response()->json(['status' => true, 'data' => $query->orderBy('title')->get(['title'])]);
    }
}
