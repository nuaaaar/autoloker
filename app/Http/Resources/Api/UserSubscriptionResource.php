<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'master_subscription_id' => $this->master_subscription_id,
            'user_order_manual_id' => $this->user_order_manual_id,
            'role' => $this->role,
            'subscription_name' => $this->subscription_name,
            'price' => (float) $this->price,
            'started_at' => $this->started_at,
            'expired_at' => $this->expired_at,
            'status' => $this->status,
            'limits' => $this->featureObject($this->limits),
            'notes' => $this->notes,
            'cancelled_at' => $this->cancelled_at,
            'remaining_days' => (int) $this->remainingDays(),
            'is_active' => $this->isActive(),
            'limit_usage' => $this->limit_usage ?? [
                'total_active_job_applications' => 0,
                'total_active_training_applications' => 0,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function featureObject(mixed $value): ?object
    {
        if ($value === null) {
            return null;
        }

        if (is_object($value)) {
            return $value;
        }

        if (is_array($value)) {
            return (object) $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return (object) [];
        }

        $decoded = json_decode($value);

        return is_object($decoded) ? $decoded : (object) [];
    }
}
