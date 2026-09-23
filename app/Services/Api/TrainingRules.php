<?php

namespace App\Services\Api;

use DateTimeImmutable;
use Illuminate\Validation\Rule;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

final class TrainingRules
{
    public static function create(bool $hasPosterFile = false): array
    {
        return array_merge([
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'level' => ['sometimes', 'nullable', 'string', 'max:255'],
            'is_certificate' => ['sometimes', 'boolean'],
            'tags' => ['sometimes', 'nullable', 'array'],
            'tags.*' => ['string', 'min:1', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'start_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'end_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'total_jp' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'training_mode' => ['sometimes', 'nullable', Rule::in(self::trainingModes())],
            'province' => ['sometimes', 'nullable', 'string', 'max:255'],
            'city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string'],
            'syllabus' => ['sometimes', 'nullable', 'array'],
            'syllabus.*' => ['string', 'min:1', 'max:255'],
            'requirements' => ['sometimes', 'nullable', 'array'],
            'requirements.*' => ['string', 'min:1', 'max:255'],
            'instructor' => ['sometimes', 'nullable', 'string', 'max:255'],
            'quota' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'price' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'workflow_action' => ['sometimes', Rule::in(['save_draft', 'submit'])],
        ], ['poster' => self::poster($hasPosterFile)]);
    }

    public static function update(bool $hasPosterFile = false): array
    {
        $rules = self::create($hasPosterFile);
        $rules['title'] = ['sometimes', 'string', 'min:3', 'max:200'];
        unset($rules['workflow_action']);

        return $rules;
    }

    public static function complete(bool $hasPosterFile = false): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'category' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'is_certificate' => ['sometimes', 'boolean'],
            'tags' => ['sometimes', 'nullable', 'array'],
            'tags.*' => ['string', 'min:1', 'max:255'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d'],
            'total_jp' => ['required', 'integer', 'min:1'],
            'training_mode' => ['required', Rule::in(self::trainingModes())],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'syllabus' => ['required', 'array', 'min:1'],
            'syllabus.*' => ['string', 'min:1', 'max:255'],
            'requirements' => ['required', 'array', 'min:1'],
            'requirements.*' => ['string', 'min:1', 'max:255'],
            'instructor' => ['sometimes', 'nullable', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'price' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'poster' => self::poster($hasPosterFile),
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
            'registered',
            'registered_count',
            'approved_count',
            'approved_applications_count',
            'total_clicked',
            'applications_count',
            'bookmarks_count',
            'progress',
            'progress_percentage',
            'price_display',
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

    public static function trainingModes(): array
    {
        return ['online', 'offline', 'hybrid'];
    }

    public static function normalizeArrayInputs(array $data): array
    {
        foreach (['tags', 'syllabus', 'requirements'] as $field) {
            if (! isset($data[$field]) || ! is_string($data[$field])) {
                continue;
            }

            $decoded = json_decode($data[$field], true);
            if (is_array($decoded)) {
                $data[$field] = $decoded;
            }
        }

        return $data;
    }

    /** @return array<string, list<string>> */
    public static function arrayErrors(array $data): array
    {
        $errors = [];

        foreach (['tags', 'syllabus', 'requirements'] as $field) {
            if (! array_key_exists($field, $data) || ! is_array($data[$field])) {
                continue;
            }

            $seen = [];
            foreach ($data[$field] as $index => $item) {
                if (! is_string($item) || trim($item) === '') {
                    $errors["{$field}.{$index}"][] = 'The item must not be empty.';
                    continue;
                }

                if ($field === 'tags') {
                    $key = mb_strtolower(trim($item));
                    if (isset($seen[$key])) {
                        $errors["{$field}.{$index}"][] = 'The tags must not contain duplicates.';
                    }
                    $seen[$key] = true;
                }
            }
        }

        return $errors;
    }

    /** @return array<string, list<string>> */
    public static function dateErrors(array $data): array
    {
        $start = $data['start_date'] ?? null;
        $end = $data['end_date'] ?? null;

        if (! is_string($start) || ! is_string($end) || trim($start) === '' || trim($end) === '') {
            return [];
        }

        $startDate = DateTimeImmutable::createFromFormat('!Y-m-d', $start);
        $endDate = DateTimeImmutable::createFromFormat('!Y-m-d', $end);
        if (! $startDate || ! $endDate || $endDate >= $startDate) {
            return [];
        }

        return [
            'start_date' => ['The start date must be before or equal to the end date.'],
            'end_date' => ['The end date must be greater than or equal to the start date.'],
        ];
    }

    /** @return array<string, list<string>> */
    public static function locationErrors(array $data, bool $requirePair = false): array
    {
        $provinceName = $data['province'] ?? null;
        $cityName = $data['city'] ?? null;
        $provinceBlank = ! is_string($provinceName) || trim($provinceName) === '';
        $cityBlank = ! is_string($cityName) || trim($cityName) === '';

        if ($provinceBlank && $cityBlank && ! $requirePair) {
            return [];
        }

        $errors = [];
        if ($provinceBlank) {
            $errors['province'][] = 'The province is required when a city is provided.';
        }
        if ($cityBlank) {
            $errors['city'][] = 'The city is required when a province is provided.';
        }
        if ($errors !== []) {
            return $errors;
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

    /** @return list<mixed> */
    private static function poster(bool $hasPosterFile): array
    {
        if ($hasPosterFile) {
            return ['sometimes', 'nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
        }

        return [
            'sometimes',
            'nullable',
            'string',
            'max:2048',
            function (string $attribute, mixed $value, \Closure $fail): void {
                if (is_string($value) && preg_match('/^(?:[A-Za-z]:[\\\\\/]|\\\\\\\\|\\/)(?:home|root|var|tmp|private|Users)(?:[\\\\\/]|$)/i', $value)) {
                    $fail('The poster must be a public storage key or path.');
                }
            },
        ];
    }
}
