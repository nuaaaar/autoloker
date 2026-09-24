<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnedJobVacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $bujp = $this->resource->relationLoaded('bujp')
            ? $this->resource->getRelation('bujp')
            : $this->resource->bujp;
        $company = $this->resource->relationLoaded('company')
            ? $this->resource->getRelation('company')
            : $this->resource->company;

        $data = [
            'uuid' => $this->uuid,
            'position' => $this->position,
            'status' => $this->status,
            'bujp' => $bujp ? [
                'uuid' => $bujp->uuid,
                'name' => $bujp->company_name,
            ] : null,
            'company' => $company ? [
                'uuid' => $company->uuid,
                'name' => $company->company_name,
            ] : null,
            'province' => $this->province,
            'city' => $this->city,
            'address' => $this->address,
            'working_type' => $this->working_type,
            'working_system' => $this->working_system,
            'description_work' => $this->description_work,
            'responsibilities' => $this->arrayValue($this->responsibility),
            'min_age' => $this->numberValue($this->min_age),
            'max_age' => $this->numberValue($this->max_age),
            'min_height' => $this->numberValue($this->min_height),
            'max_height' => $this->numberValue($this->max_height),
            'min_weight' => $this->numberValue($this->min_weight),
            'max_weight' => $this->numberValue($this->max_weight),
            'last_education' => $this->last_education,
            'min_experience' => $this->numberValue($this->min_experience),
            'gender' => $this->gender,
            'certificate' => $this->arrayValue($this->certificate),
            'competency_scheme' => $this->arrayValue($this->competency_scheme),
            'facility' => $this->arrayValue($this->facility),
            'min_price' => $this->numberValue($this->min_price),
            'max_price' => $this->numberValue($this->max_price),
            'is_show_fee' => (bool) $this->is_show_fee,
            'is_urgent' => (bool) $this->is_urgent,
            'quota' => $this->numberValue($this->kuota),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'fee_type' => $this->fee_type,
            'reason_rejected' => $this->reason_rejected,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if (array_key_exists('total_applications', $this->resource->getAttributes())) {
            $data['total_applications'] = (int) $this->total_applications;
        }

        return $data;
    }

    private function arrayValue(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function numberValue(mixed $value): int|float|null
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        $number = (float) $value;

        return floor($number) === $number ? (int) $number : $number;
    }
}
