<?php

namespace App\Services\Api;

use Illuminate\Validation\Rule;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

final class JobVacancyRules
{
    public static function create(): array
    {
        $rules = self::shared();
        $rules['position'] = ['required', 'string', 'min:3', 'max:150'];
        $rules['workflow_action'] = ['sometimes', Rule::in(['save_draft', 'submit'])];

        return $rules;
    }

    public static function update(): array
    {
        return self::shared();
    }

    public static function complete(): array
    {
        return [
            'position' => ['required', 'string', 'min:3', 'max:150'],
            'description_work' => ['required', 'string'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'working_type' => ['required', 'string', Rule::in(self::workingTypes())],
            'working_system' => ['required', 'string', Rule::in(self::workingSystems())],
            'responsibilities' => ['required', 'array', 'min:1'],
            'responsibilities.*' => ['string', 'max:255'],
            'min_age' => ['required', 'integer', 'between:18,100'],
            'max_age' => ['required', 'integer', 'between:18,100'],
            'min_height' => ['required', 'numeric', 'min:0'],
            'max_height' => ['required', 'numeric', 'min:0'],
            'min_weight' => ['required', 'numeric', 'min:0'],
            'max_weight' => ['required', 'numeric', 'min:0'],
            'last_education' => ['required', 'string'],
            'min_experience' => ['required', 'integer', 'min:0'],
            'certificate' => ['required', 'array', 'min:1'],
            'certificate.*' => ['string', 'max:255'],
            'competency_scheme' => ['required', 'array', 'min:1'],
            'competency_scheme.*' => ['string', 'max:255'],
            'facility' => ['required', 'array', 'min:1'],
            'facility.*' => ['string', 'max:255'],
            'min_price' => ['required', 'numeric', 'min:0'],
            'max_price' => ['required', 'numeric', 'min:0'],
            'is_show_fee' => ['required', 'boolean'],
            'is_urgent' => ['required', 'boolean'],
            'quota' => ['required', 'integer', 'min:1'],
            'end_date' => ['required', 'date_format:Y-m-d'],
        ];
    }

    public static function immutable(): array
    {
        $fields = [
            'id',
            'uuid',
            'bujp_id',
            'b_u_j_p_id',
            'company_id',
            'owner',
            'owner_id',
            'bujp_uuid',
            'company_uuid',
            'company_name',
            'provider',
            'status',
            'reason_rejected',
            'created_at',
            'updated_at',
            'timestamps',
            'total_clicked',
            'total_applications',
            'applications_count',
            'bookmarks_count',
            'is_applied',
            'is_appled',
        ];

        return array_fill_keys($fields, ['prohibited']);
    }

    public static function submit(): array
    {
        return array_merge(self::immutable(), [
            'workflow_action' => ['prohibited'],
        ]);
    }

    public static function locationErrors(array $data): array
    {
        $provinceName = $data['province'] ?? null;
        $cityName = $data['city'] ?? null;

        if (! is_string($provinceName) || ! is_string($cityName) || trim($provinceName) === '' || trim($cityName) === '') {
            return [];
        }

        $province = Province::query()
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($provinceName))])
            ->first(['code']);

        if (! $province) {
            return ['province' => ['The selected province is invalid.']];
        }

        $cityExists = City::query()
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($cityName))])
            ->where('province_code', $province->code)
            ->exists();

        return $cityExists
            ? []
            : ['city' => ['The selected city is not in the selected province.']];
    }

    public static function rangeErrors(array $data): array
    {
        $errors = [];

        foreach ([
            'min_age' => 'max_age',
            'min_height' => 'max_height',
            'min_weight' => 'max_weight',
            'min_price' => 'max_price',
        ] as $minimum => $maximum) {
            $min = $data[$minimum] ?? null;
            $max = $data[$maximum] ?? null;

            if ($min !== null && $max !== null && is_numeric($min) && is_numeric($max) && (float) $min > (float) $max) {
                $message = "The {$maximum} must be greater than or equal to {$minimum}.";
                $errors[$minimum][] = $message;
                $errors[$maximum][] = $message;
            }
        }

        return $errors;
    }

    public static function workingTypes(): array
    {
        return ['permanent', 'contract', 'intenrship', 'freelance'];
    }

    public static function workingSystems(): array
    {
        return ['shift', 'non-shift'];
    }

    private static function shared(): array
    {
        return [
            'position' => ['sometimes', 'string', 'min:3', 'max:150'],
            'description_work' => ['sometimes', 'nullable', 'string'],
            'province' => ['sometimes', 'nullable', 'string', 'max:255'],
            'city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string'],
            'working_type' => ['sometimes', 'string', Rule::in(self::workingTypes())],
            'working_system' => ['sometimes', 'string', Rule::in(self::workingSystems())],
            'responsibilities' => ['sometimes', 'nullable', 'array'],
            'responsibilities.*' => ['string', 'max:255'],
            'min_age' => ['sometimes', 'nullable', 'integer', 'between:18,100'],
            'max_age' => ['sometimes', 'nullable', 'integer', 'between:18,100'],
            'min_height' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'max_height' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'min_weight' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'max_weight' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'last_education' => ['sometimes', 'nullable', 'string'],
            'min_experience' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'certificate' => ['sometimes', 'nullable', 'array'],
            'certificate.*' => ['string', 'max:255'],
            'competency_scheme' => ['sometimes', 'nullable', 'array'],
            'competency_scheme.*' => ['string', 'max:255'],
            'facility' => ['sometimes', 'nullable', 'array'],
            'facility.*' => ['string', 'max:255'],
            'min_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'max_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'is_show_fee' => ['sometimes', 'boolean'],
            'is_urgent' => ['sometimes', 'boolean'],
            'quota' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'end_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
        ];
    }
}
