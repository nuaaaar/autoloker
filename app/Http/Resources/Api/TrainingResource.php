<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingResource extends JsonResource
{
    private const ARRAY_FIELDS = [
        'tags',
        'syllabus',
        'requirements',
    ];

    public function toArray(Request $request): array
    {
        $data = $this->resource->toArray();

        foreach (self::ARRAY_FIELDS as $field) {
            $data[$field] = $this->normalizeArray($data[$field] ?? null);
        }

        return $data;
    }

    private function normalizeArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }
}
