<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnedTrainingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $bujp = $this->resource->relationLoaded('bujp')
            ? $this->resource->getRelation('bujp')
            : $this->resource->bujp;

        $quota = $this->integerValue($this->quota);
        $registered = $this->integerValue($this->resource->getAttribute('registered_count'));
        $approved = $this->integerValue($this->resource->getAttribute('approved_count'));
        $progress = $quota > 0
            ? min(1, round($approved / $quota, 4))
            : 0;

        return [
            'uuid' => (string) $this->uuid,
            'title' => $this->title,
            'provider' => $bujp ? [
                'uuid' => (string) $bujp->uuid,
                'name' => $bujp->company_name,
            ] : null,
            'status' => $this->status,
            'poster' => $this->poster,
            'category' => $this->category,
            'level' => $this->level,
            'is_certificate' => (bool) $this->is_certificate,
            'tags' => $this->arrayValue($this->tags),
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'duration_day' => $this->nullableInteger($this->duration_day),
            'total_jp' => $this->nullableInteger($this->total_jp),
            'training_mode' => $this->training_mode,
            'province' => ['name' => $this->province],
            'city' => ['name' => $this->city],
            'address' => $this->address,
            'syllabus' => $this->arrayValue($this->syllabus),
            'requirements' => $this->arrayValue($this->requirements),
            'instructor' => $this->instructor,
            'quota' => $this->nullableInteger($this->quota),
            'price' => $this->nullableInteger($this->price),
            'registered_count' => $registered,
            'approved_count' => $approved,
            'progress' => $progress,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
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

    private function nullableInteger(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? (int) $value : null;
    }

    private function integerValue(mixed $value): int
    {
        return is_numeric($value) ? max(0, (int) $value) : 0;
    }
}
