<?php

namespace App\Http\Resources\Api;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        unset($data['level']);
        $data['discount'] = is_numeric($data['discount'] ?? null) ? (float) $data['discount'] : 0.0;

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

        if (array_key_exists('is_applied', $data)) {
            $data['is_applied'] = (bool) $data['is_applied'];
        }

        $quota = $this->numericValue($data['quota'] ?? null);
        $registered = $this->numericValue(
            $data['registered'] ?? $data['approved_applications_count'] ?? null
        );
        $price = $this->numericValue($data['price'] ?? null);
        $progress = $quota > 0
            ? min(100, (int) round(($registered / $quota) * 100))
            : 0;

        $data['registered_count'] = $registered;
        $data['progress_percentage'] = $progress;
        $data['price_display'] = $price > 0
            ? 'Rp '.number_format($price, 0, ',', '.')
            : 'Gratis';

        unset($data['approved_applications_count']);

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

    private function numericValue(mixed $value): int
    {
        return is_numeric($value) ? max(0, (int) $value) : 0;
    }
}
