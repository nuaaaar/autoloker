<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterAbility;
use App\Models\MasterBank;
use App\Models\MasterCategoryCertificate;
use App\Models\MasterIndustry;
use App\Models\MasterSubscription;
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
    private const SUBSCRIPTION_ROLE_MAPPING = [
        'satpam' => 'security',
        'bujp' => 'bujp',
        'company' => 'client',
        'perusahaan' => 'client',
    ];

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

    public function banks(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => MasterBank::query()
                ->orderBy('bank_name')
                ->orderBy('id')
                ->get(['id', 'uuid', 'account_name', 'bank_number', 'bank_name']),
        ]);
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

    public function subscriptions(Request $request): JsonResponse
    {
        $role = self::SUBSCRIPTION_ROLE_MAPPING[
            strtolower(trim((string) $request->user()?->role))
        ] ?? null;

        $subscriptions = $role === null
            ? collect()
            : MasterSubscription::query()
                ->where('role', $role)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
            ->get([
                'id',
                'uuid',
                'name',
                'slug',
                'role',
                'price',
                'duration',
                'duration_type',
                'description',
                'features',
                'is_active',
                'sort_order',
            ])
            ->map(function (MasterSubscription $subscription): array {
                return [
                    'id' => $subscription->id,
                    'uuid' => $subscription->uuid,
                    'name' => $subscription->name,
                    'slug' => $subscription->slug,
                    'role' => $subscription->role,
                    'price' => $subscription->price,
                    'duration' => $subscription->duration,
                    'duration_type' => $subscription->duration_type,
                    'description' => $subscription->description,
                    'features' => $this->decodeFeatures($subscription->features),
                    'is_active' => (bool) $subscription->is_active,
                    'sort_order' => $subscription->sort_order,
                ];
            })
            ->values();

        return response()->json([
            'status' => true,
            'data' => $subscriptions,
        ]);
    }

    private function decodeFeatures(mixed $features): ?object
    {
        if ($features === null || ! is_string($features) || trim($features) === '') {
            return $features === null ? null : (object) [];
        }

        $decoded = json_decode($features);

        return is_object($decoded) ? $decoded : (object) [];
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
