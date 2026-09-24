<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderManualResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'master_subscription_id' => $this->master_subscription_id,
            'role' => $this->role,
            'order_number' => $this->order_number,
            'price' => $this->price,
            'payment_method' => $this->payment_method,
            'payment_account' => $this->payment_account,
            'payment_date' => $this->payment_date,
            'file' => $this->file,
            'status' => $this->status,
            'notes' => $this->notes,
            'rejected_reason' => $this->rejected_reason,
            'verified_by' => $this->verified_by,
            'verified_at' => $this->verified_at,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'subscription' => $this->whenLoaded('subscription', function (): ?array {
                $subscription = $this->subscription;

                if (! $subscription) {
                    return null;
                }

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
                    'features' => $subscription->features,
                    'is_active' => (bool) $subscription->is_active,
                    'sort_order' => $subscription->sort_order,
                ];
            }),
        ];
    }
}
