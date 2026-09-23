<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobVacancyResource extends JsonResource
{
    private const ARRAY_FIELDS = [
        'responsibility',
        'facility',
        'certificate',
        'competency_scheme',
    ];

    public function toArray(Request $request): array
    {
        $data = $this->resource->toArray();

        foreach (self::ARRAY_FIELDS as $field) {
            $data[$field] = $this->normalizeArray($data[$field] ?? null);
        }
        if (array_key_exists('total_applications', $data)) {
            $data['total_applications'] = (int) $data['total_applications'];
        }

        if (array_key_exists('is_applied', $data)) {
            $data['is_applied'] = (bool) $data['is_applied'];
            $data['is_appled'] = $data['is_applied'];
        } elseif (array_key_exists('is_appled', $data)) {
            $data['is_appled'] = (bool) $data['is_appled'];
            $data['is_applied'] = $data['is_appled'];
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
