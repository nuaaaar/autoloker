<?php

namespace App\Services\Api;

use App\Models\BUJP;
use App\Models\Training;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class TrainingService
{
    public function create(int $ownerId, array $data): Training
    {
        $action = $data['workflow_action'] ?? 'save_draft';
        unset($data['workflow_action']);
        $data = TrainingRules::normalizeArrayInputs($data);
        [$data, $locationErrors] = $this->normalizeLocation($data);
        $this->validatePayload($data, $action === 'submit', $locationErrors);

        $bujp = BUJP::query()->findOrFail($ownerId);
        $attributes = $this->attributes($data);
        $attributes['b_u_j_p_id'] = $ownerId;
        $attributes['company_id'] = null;
        $attributes['provider'] = $bujp->company_name;
        $attributes['registered'] = 0;
        $attributes['total_clicked'] = 0;
        $attributes['duration_day'] = $this->durationDay($data['start_date'] ?? null, $data['end_date'] ?? null);
        $attributes['status'] = $action === 'submit' ? 'submitted' : 'draft';
        $attributes['reason_rejected'] = null;

        return DB::transaction(fn (): Training => Training::create($attributes));
    }

    public function update(Training $training, array $data): Training
    {
        $data = TrainingRules::normalizeArrayInputs($data);
        $merged = array_merge($this->payload($training), $data);
        [$merged, $locationErrors] = $this->normalizeLocation($merged);
        $this->validatePayload($merged, false, $locationErrors);

        foreach (['province', 'city'] as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $merged[$field];
            }
        }

        $attributes = $this->attributes($data);
        if (array_key_exists('start_date', $data) || array_key_exists('end_date', $data)) {
            $attributes['duration_day'] = $this->durationDay(
                $merged['start_date'] ?? null,
                $merged['end_date'] ?? null,
            );
        }

        return DB::transaction(function () use ($training, $attributes): Training {
            if (array_key_exists('quota', $attributes)) {
                $this->ensureQuotaAllowsActiveParticipants($training, $attributes['quota']);
            }

            if ($attributes !== []) {
                $training->fill($attributes);
                $training->save();
            }

            return $training->fresh();
        });
    }

    public function submit(Training $training): Training
    {
        if (! in_array($training->status, ['draft', 'rejected'], true)) {
            $this->throwValidation([
                'status' => ['Only draft or rejected trainings can be submitted.'],
            ]);
        }

        $payload = $this->payload($training);
        [$payload, $locationErrors] = $this->normalizeLocation($payload);
        $this->validatePayload($payload, true, $locationErrors);

        $durationDay = $this->durationDay($payload['start_date'] ?? null, $payload['end_date'] ?? null);

        return DB::transaction(function () use ($training, $durationDay): Training {
            $training->forceFill([
                'status' => 'submitted',
                'reason_rejected' => null,
                'duration_day' => $durationDay,
            ])->save();

            return $training->fresh();
        });
    }

    /** @param array<string, list<string>> $locationErrors */
    private function validatePayload(array $data, bool $complete, array $locationErrors = []): void
    {
        $validator = Validator::make(
            $data,
            $complete
                ? TrainingRules::complete(isset($data['poster']) && $data['poster'] instanceof UploadedFile)
                : TrainingRules::create(isset($data['poster']) && $data['poster'] instanceof UploadedFile),
        );

        $validator->after(function ($validator) use ($data, $locationErrors): void {
            foreach (array_merge(
                TrainingRules::dateErrors($data),
                TrainingRules::arrayErrors($data),
                $locationErrors,
            ) as $field => $messages) {
                foreach ($messages as $message) {
                    $validator->errors()->add($field, $message);
                }
            }
        });

        if ($validator->fails()) {
            $this->throwValidation($validator->errors()->toArray());
        }
    }

    /** @return array{0: array, 1: array<string, list<string>>} */
    private function normalizeLocation(array $data): array
    {
        $errors = TrainingRules::locationErrors($data);
        if ($errors !== []) {
            return [$data, $errors];
        }

        $provinceName = $data['province'] ?? null;
        $cityName = $data['city'] ?? null;
        if (! is_string($provinceName) || ! is_string($cityName) || trim($provinceName) === '' || trim($cityName) === '') {
            return [$data, []];
        }

        $province = Province::query()
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($provinceName))])
            ->first(['code', 'name']);
        $city = $province
            ? City::query()
                ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($cityName))])
                ->where('province_code', $province->code)
                ->first(['name'])
            : null;

        if (! $province || ! $city) {
            return [$data, $errors];
        }

        $data['province'] = $province->name;
        $data['city'] = $city->name;

        return [$data, $errors];
    }

    /** @return array<string, mixed> */
    private function attributes(array $data): array
    {
        $fields = [
            'title',
            'category',
            'level',
            'description',
            'start_date',
            'end_date',
            'total_jp',
            'training_mode',
            'province',
            'city',
            'address',
            'instructor',
            'quota',
            'price',
            'poster',
        ];
        $attributes = [];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $attributes[$field] = $field === 'poster'
                    ? $this->posterValue($data[$field])
                    : $data[$field];
            }
        }

        if (array_key_exists('is_certificate', $data)) {
            $attributes['is_certificate'] = (bool) $data['is_certificate'];
        }

        foreach (['tags', 'syllabus', 'requirements'] as $field) {
            if (array_key_exists($field, $data)) {
                $attributes[$field] = $data[$field] === null
                    ? null
                    : json_encode($data[$field], JSON_UNESCAPED_UNICODE);
            }
        }

        return $attributes;
    }

    private function posterValue(mixed $poster): mixed
    {
        if ($poster instanceof UploadedFile) {
            return $poster->store('training/posters', 'public');
        }

        return $poster;
    }

    private function durationDay(mixed $start, mixed $end): ?int
    {
        if (! is_string($start) || ! is_string($end) || trim($start) === '' || trim($end) === '') {
            return null;
        }

        $startDate = \Carbon\CarbonImmutable::createFromFormat('Y-m-d', $start);
        $endDate = \Carbon\CarbonImmutable::createFromFormat('Y-m-d', $end);
        if (! $startDate || ! $endDate || $endDate->lessThan($startDate)) {
            return null;
        }

        return $startDate->diffInDays($endDate) + 1;
    }

    private function ensureQuotaAllowsActiveParticipants(Training $training, mixed $quota): void
    {
        if ($quota === null || $quota === '') {
            return;
        }

        $activeParticipants = $training->applications()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ((int) $quota < $activeParticipants) {
            $this->throwConflict([
                'quota' => ["The quota cannot be lower than the {$activeParticipants} active participants."],
            ]);
        }
    }

    /** @return array<string, mixed> */
    private function payload(Training $training): array
    {
        return [
            'title' => $training->title,
            'category' => $training->category,
            'level' => $training->level,
            'is_certificate' => $training->is_certificate,
            'tags' => $this->decodeArray($training->tags),
            'description' => $training->description,
            'start_date' => $training->start_date,
            'end_date' => $training->end_date,
            'total_jp' => $training->total_jp,
            'training_mode' => $training->training_mode,
            'province' => $training->province,
            'city' => $training->city,
            'address' => $training->address,
            'syllabus' => $this->decodeArray($training->syllabus),
            'requirements' => $this->decodeArray($training->requirements),
            'instructor' => $training->instructor,
            'quota' => $training->quota,
            'price' => $training->price,
            'poster' => $training->poster,
        ];
    }

    private function decodeArray(mixed $value): ?array
    {
        if (is_array($value)) {
            return $value;
        }
        if ($value === null || (is_string($value) && trim($value) === '')) {
            return $value === null ? null : [];
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? $decoded : [];
    }

    /** @param array<string, list<string>> $errors */
    private function throwValidation(array $errors): never
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'The given data was invalid.',
            'data' => null,
            'errors' => $errors,
        ], 422));
    }

    /** @param array<string, list<string>> $errors */
    private function throwConflict(array $errors): never
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'The request conflicts with the current training participants.',
            'data' => null,
            'errors' => $errors,
        ], 409));
    }
}
