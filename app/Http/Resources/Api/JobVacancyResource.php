<?php

namespace App\Http\Resources\Api;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $data['security_position'] = $this->security_position;

        foreach (['bujp', 'company'] as $organization) {
            if (! is_array($data[$organization] ?? null)) {
                continue;
            }

            $path = $data[$organization]['logo'] ?? null;
            $data[$organization]['logo'] = is_string($path) && $path !== ''
                ? Storage::disk('public')->url($path)
                : null;
        }

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
