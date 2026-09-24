<?php

namespace App\Services\Api;

use App\Models\JobVacancy;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class JobVacancyService
{
    public function create(array $owner, array $data): JobVacancy
    {
        $action = $data['workflow_action'] ?? 'save_draft';
        unset($data['workflow_action']);

        $data = $this->validatePayload($data, $action === 'submit', true);

        $attributes = $this->attributes($data);
        $attributes['b_u_j_p_id'] = null;
        $attributes['company_id'] = null;
        $attributes[$owner['column']] = $owner['id'];
        $attributes['status'] = $action === 'submit' ? 'submitted' : 'draft';
        $attributes['reason_rejected'] = null;

        return DB::transaction(fn (): JobVacancy => JobVacancy::create($attributes));
    }

    public function update(JobVacancy $vacancy, array $data): JobVacancy
    {
        $merged = array_merge($this->payload($vacancy), $data);
        $validateLocation = array_key_exists('province', $data) || array_key_exists('city', $data);
        $normalized = $this->validatePayload($merged, false, $validateLocation);

        foreach (['province', 'city'] as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $normalized[$field];
            }
        }

        $attributes = $this->attributes($data);

        if ($attributes !== []) {
            $vacancy->fill($attributes);
            $vacancy->save();
        }

        return $vacancy->fresh();
    }

    public function submit(JobVacancy $vacancy): JobVacancy
    {
        if (! in_array($vacancy->status, ['draft', 'rejected'], true)) {
            $this->throwErrors([
                'status' => ['Only draft or rejected job vacancies can be submitted.'],
            ]);
        }

        $this->validatePayload($this->payload($vacancy), true, true);

        $vacancy->forceFill([
            'status' => 'submitted',
            'reason_rejected' => null,
        ])->save();

        return $vacancy->fresh();
    }

    private function validatePayload(array $data, bool $complete, bool $validateLocation = false): array
    {
        [$data, $locationErrors] = $validateLocation
            ? $this->normalizeLocation($data)
            : [$data, []];
        $validator = Validator::make(
            $data,
            $complete ? JobVacancyRules::complete() : JobVacancyRules::update(),
        );

        $validator->after(function ($validator) use ($data, $locationErrors): void {
            foreach (JobVacancyRules::rangeErrors($data) as $field => $messages) {
                foreach ($messages as $message) {
                    $validator->errors()->add($field, $message);
                }
            }

            foreach ($locationErrors as $field => $messages) {
                foreach ($messages as $message) {
                    $validator->errors()->add($field, $message);
                }
            }
        });

        if ($validator->fails()) {
            $this->throwValidatorErrors($validator);
        }

        return $data;
    }

    /** @return array{0: array, 1: array<string, list<string>>} */
    private function normalizeLocation(array $data): array
    {
        $errors = [];
        $provinceName = $data['province'] ?? null;
        $cityName = $data['city'] ?? null;

        if (! is_string($provinceName) || ! is_string($cityName) || $provinceName === '' || $cityName === '') {
            return [$data, $errors];
        }

        $province = Province::query()
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($provinceName))])
            ->first(['code', 'name']);

        if (! $province) {
            $errors['province'][] = 'The selected province is invalid.';

            return [$data, $errors];
        }

        $cities = City::query()
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($cityName))])
            ->get(['code', 'province_code', 'name']);
        $city = $cities->firstWhere('province_code', $province->code);

        if (! $city) {
            $errors['city'][] = 'The selected city is not in the selected province.';

            return [$data, $errors];
        }

        $data['province'] = $province->name;
        $data['city'] = $city->name;

        return [$data, $errors];
    }

    private function attributes(array $data): array
    {
        $mapping = [
            'position' => 'position',
            'description_work' => 'description_work',
            'province' => 'province',
            'city' => 'city',
            'address' => 'address',
            'working_type' => 'working_type',
            'working_system' => 'working_system',
            'responsibilities' => 'responsibility',
            'min_age' => 'min_age',
            'max_age' => 'max_age',
            'min_height' => 'min_height',
            'max_height' => 'max_height',
            'min_weight' => 'min_weight',
            'max_weight' => 'max_weight',
            'last_education' => 'last_education',
            'min_experience' => 'min_experience',
            'certificate' => 'certificate',
            'competency_scheme' => 'competency_scheme',
            'facility' => 'facility',
            'min_price' => 'min_price',
            'max_price' => 'max_price',
            'is_show_fee' => 'is_show_fee',
            'is_urgent' => 'is_urgent',
            'quota' => 'kuota',
            'end_date' => 'end_date',
        ];
        $attributes = [];

        foreach ($mapping as $input => $column) {
            if (! array_key_exists($input, $data)) {
                continue;
            }

            $value = $data[$input];
            $attributes[$column] = in_array($input, ['responsibilities', 'certificate', 'competency_scheme', 'facility'], true)
                ? ($value === null ? null : json_encode($value, JSON_UNESCAPED_UNICODE))
                : $value;
        }

        return $attributes;
    }

    private function payload(JobVacancy $vacancy): array
    {
        return [
            'position' => $vacancy->position,
            'description_work' => $vacancy->description_work,
            'province' => $vacancy->province,
            'city' => $vacancy->city,
            'address' => $vacancy->address,
            'working_type' => $vacancy->working_type,
            'working_system' => $vacancy->working_system,
            'responsibilities' => $this->decodeArray($vacancy->responsibility),
            'min_age' => $vacancy->min_age,
            'max_age' => $vacancy->max_age,
            'min_height' => $vacancy->min_height,
            'max_height' => $vacancy->max_height,
            'min_weight' => $vacancy->min_weight,
            'max_weight' => $vacancy->max_weight,
            'last_education' => $vacancy->last_education,
            'min_experience' => $vacancy->min_experience,
            'certificate' => $this->decodeArray($vacancy->certificate),
            'competency_scheme' => $this->decodeArray($vacancy->competency_scheme),
            'facility' => $this->decodeArray($vacancy->facility),
            'min_price' => $vacancy->min_price,
            'max_price' => $vacancy->max_price,
            'is_show_fee' => $vacancy->is_show_fee,
            'is_urgent' => $vacancy->is_urgent,
            'quota' => $vacancy->kuota,
            'end_date' => $vacancy->end_date,
        ];
    }

    private function decodeArray(mixed $value): ?array
    {
        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return $value === null ? null : [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function throwValidatorErrors($validator): never
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'The given data was invalid.',
            'data' => null,
            'errors' => $validator->errors(),
        ], 422));
    }

    /** @param array<string, list<string>> $errors */
    private function throwErrors(array $errors): never
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'The given data was invalid.',
            'data' => null,
            'errors' => $errors,
        ], 422));
    }
}
