<?php

namespace App\Http\Resources\Api;

use App\Models\MasterSubscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Canonical master subscription payload.
 *
 * Used by the plan listing endpoint and by subscriptions embedded in manual
 * orders so both surfaces shape `features`, `price`, and the boolean flags
 * identically.
 */
class MasterSubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return self::shape($this->resource);
    }

    /**
     * @return array<string, mixed>
     */
    public static function shape(MasterSubscription $subscription): array
    {
        return [
            'id' => $subscription->id,
            'uuid' => $subscription->uuid,
            'name' => $subscription->name,
            'slug' => $subscription->slug,
            'role' => $subscription->role,
            'price' => (float) $subscription->price,
            'duration' => $subscription->duration,
            'duration_type' => $subscription->duration_type,
            'description' => $subscription->description,
            'features' => self::featureObject($subscription->features),
            'is_active' => (bool) $subscription->is_active,
            'is_highlight' => (bool) $subscription->is_highlight,
            'sort_order' => $subscription->sort_order,
        ];
    }

    public static function featureObject(mixed $features): ?object
    {
        if ($features === null) {
            return null;
        }

        if (is_object($features)) {
            return $features;
        }

        if (is_array($features)) {
            return (object) $features;
        }

        if (! is_string($features) || trim($features) === '') {
            return (object) [];
        }

        $decoded = json_decode($features);

        return is_object($decoded) ? $decoded : (object) [];
    }
}
