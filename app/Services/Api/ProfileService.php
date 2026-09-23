<?php

namespace App\Services\Api;

use App\Models\BUJP;
use App\Models\Company;
use App\Models\User;
use App\Models\Security;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileService
{
    private const FIELDS = [
        'satpam' => [
            'formal_photo', 'name', 'birth_place', 'birth_date', 'gender',
            'address', 'phone_number', 'email', 'ktp_number',
            'registration_number', 'work_experience', 'province',
            'province_code', 'city', 'city_code', 'district', 'district_code',
            'village', 'village_code', 'height', 'width', 'is_out_of_town_agree',
            'is_shift_agree', 'ability', 'placements', 'self_description',
            'additional_note', 'work_status', 'company_name', 'position', 'sim',
        ],
        'company' => [
            'company_name', 'industry', 'logo', 'description', 'npwp', 'nib',
            'business_license', 'email', 'phone', 'website', 'province',
            'province_code', 'city', 'city_code', 'district', 'district_code',
            'village', 'village_code', 'postal_code', 'address', 'instagram',
            'facebook', 'linkedin', 'youtube',
        ],
        'bujp' => [
            'company_name', 'industry', 'logo', 'description', 'npwp', 'nib',
            'business_license', 'sio_number', 'sio_expired_date', 'sio_file',
            'email', 'phone', 'website', 'province', 'province_code', 'city',
            'city_code', 'district', 'district_code', 'village', 'village_code',
            'postal_code', 'address', 'instagram', 'facebook', 'linkedin',
            'youtube',
        ],
    ];

    public function show(User $user): array
    {
        $profile = $this->profileFor($user);

        if ($profile === null) {
            throw new NotFoundHttpException('Profile not found.');
        }

        if ($user->role === 'satpam') {
            return $this->securityProfile($profile, $user);
        }

        $this->populateMissingLocationCodes($profile);

        $profileValues = $profile->only(self::FIELDS[$user->role]);
        $profileValues = $this->withResolvedLocationCodes($profileValues);
        foreach (['ability', 'placements'] as $field) {
            if (array_key_exists($field, $profileValues)) {
                $profileValues[$field] = $profileValues[$field] === null || $profileValues[$field] === ''
                    ? []
                    : array_values(array_filter(array_map('trim', explode(',', $profileValues[$field]))));
            }
        }
        foreach (['is_out_of_town_agree', 'is_shift_agree'] as $field) {
            if (array_key_exists($field, $profileValues) && $profileValues[$field] !== null) {
                $profileValues[$field] = filter_var($profileValues[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }

        return [
            'type' => $this->apiRole($user),
            'id' => $profile->id,
            'uuid' => $profile->uuid,
            'data' => $profileValues,
            'profile_completion' => $profile->profileProgress(),
            'is_verified' => (bool) $profile->is_verified,
            'is_active' => (bool) $profile->is_active,
        ];
    }

    public function showSecurity(Security $security): array
    {
        $security->loadMissing('user_security.user');

        return $this->securityProfile(
            $security,
            $security->user_security?->user,
        );
    }

    private function securityProfile(Security $profile, ?User $user): array
    {
        $this->populateMissingLocationCodes($profile);

        $profileValues = $profile->only(self::FIELDS['satpam']);
        $profileValues = $this->withResolvedLocationCodes($profileValues);
        foreach (['ability', 'placements'] as $field) {
            if (array_key_exists($field, $profileValues)) {
                $profileValues[$field] = $profileValues[$field] === null || $profileValues[$field] === ''
                    ? []
                    : array_values(array_filter(array_map('trim', explode(',', $profileValues[$field]))));
            }
        }
        foreach (['is_out_of_town_agree', 'is_shift_agree'] as $field) {
            if (array_key_exists($field, $profileValues) && $profileValues[$field] !== null) {
                $profileValues[$field] = filter_var($profileValues[$field], FILTER_VALIDATE_BOOLEAN);
            }
        }

        return [
            'type' => 'security',
            'id' => $profile->id,
            'uuid' => $profile->uuid,
            'data' => $profileValues,
            'profile_completion' => $profile->profileProgress(),
            'is_verified' => null,
            'is_active' => $user?->status === 'active',
        ];
    }

    public function update(User $user, array $data): array
    {
        $profile = $this->profileFor($user);

        if ($profile === null) {
            throw new NotFoundHttpException('Profile not found.');
        }

        $oldFiles = [];
        $newFiles = [];
        $profileData = array_intersect_key($data, array_flip(self::FIELDS[$user->role]));
        $profileData = $this->normalize($profileData);

        foreach ($this->fileFields($user) as $field => $directory) {
            if (($profileData[$field] ?? null) instanceof UploadedFile) {
                $oldFiles[$field] = $profile->{$field};
                $newFiles[$field] = $profileData[$field]->store($directory, 'public');
                $profileData[$field] = $newFiles[$field];
            }
        }

        try {
            DB::transaction(function () use ($user, $profile, $profileData): void {
                $userData = array_intersect_key($profileData, array_flip(['name', 'email', 'phone_number']));
                if ($userData !== []) {
                    $user->update($userData);
                }

                $profile->update($profileData);
            });
        } catch (\Throwable $exception) {
            foreach ($newFiles as $path) {
                Storage::disk('public')->delete($path);
            }
            throw $exception;
        }

        foreach ($oldFiles as $path) {
            if ($path && !in_array($path, $newFiles, true)) {
                Storage::disk('public')->delete($path);
            }
        }

        return $this->show($user->fresh());
    }
    private function normalize(array $data): array
    {
        foreach ([
            'province' => [Province::class, 'province_code'],
            'city' => [City::class, 'city_code'],
            'district' => [District::class, 'district_code'],
            'village' => [Village::class, 'village_code'],
        ] as $field => [$model, $codeField]) {
            if (!array_key_exists($field, $data)) {
                continue;
            }

            if ($data[$field] === null) {
                $data[$codeField] = null;
                continue;
            }

            $data[$codeField] = $data[$field];
            $data[$field] = $model::where('code', $data[$field])->value('name');
        }

        foreach (['ability', 'placements'] as $field) {
            if (array_key_exists($field, $data) && is_array($data[$field])) {
                $data[$field] = implode(',', $data[$field]);
            }
        }

        return $data;
    }

    private function populateMissingLocationCodes(Security|Company|BUJP $profile): void
    {
        $values = $profile->only([
            'province', 'province_code', 'city', 'city_code',
            'district', 'district_code', 'village', 'village_code',
        ]);
        $resolved = $this->withResolvedLocationCodes($values);
        $updates = [];

        foreach (['province_code', 'city_code', 'district_code', 'village_code'] as $field) {
            if ($profile->{$field} === null && ($resolved[$field] ?? null) !== null) {
                $updates[$field] = $resolved[$field];
            }
        }

        if ($updates !== []) {
            $profile->update($updates);
        }
    }

    private function withResolvedLocationCodes(array $values): array
    {
        $provinceCode = $this->resolveLocationCode(
            Province::class,
            $values['province'] ?? null
        ) ?? ($values['province_code'] ?? null);

        $cityCode = $this->resolveLocationCode(
            City::class,
            $values['city'] ?? null,
            'province_code',
            $provinceCode
        ) ?? ($values['city_code'] ?? null);

        $districtCode = $this->resolveLocationCode(
            District::class,
            $values['district'] ?? null,
            'city_code',
            $cityCode
        ) ?? ($values['district_code'] ?? null);

        $villageCode = $this->resolveLocationCode(
            Village::class,
            $values['village'] ?? null,
            'district_code',
            $districtCode
        ) ?? ($values['village_code'] ?? null);

        $values['province_code'] = $provinceCode;
        $values['city_code'] = $cityCode;
        $values['district_code'] = $districtCode;
        $values['village_code'] = $villageCode;

        return $values;
    }

    private function resolveLocationCode(
        string $model,
        mixed $value,
        ?string $parentColumn = null,
        ?string $parentCode = null
    ): ?string {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        if ($parentColumn !== null && $parentCode === null) {
            return null;
        }

        $query = $model::query();

        if ($parentColumn !== null) {
            $query->where($parentColumn, $parentCode);
        }

        return $query
            ->where(function ($query) use ($value): void {
                $query
                    ->where('code', (string) $value)
                    ->orWhere('name', (string) $value);
            })
            ->value('code');
    }


    private function profileFor(User $user): Security|Company|BUJP|null
    {
        return match ($user->role) {
            'satpam' => $user->user_security?->security,
            'company' => $user->user_company?->company,
            'bujp' => $user->user_bujp?->bujp,
            default => null,
        };
    }

    private function apiRole(User $user): string
    {
        return $user->role === 'satpam' ? 'security' : $user->role;
    }

    private function fileFields(User $user): array
    {
        return match ($user->role) {
            'satpam' => ['formal_photo' => 'formal-photo'],
            'company' => ['logo' => 'company-logo'],
            'bujp' => ['logo' => 'company-logo', 'sio_file' => 'sio-file'],
            default => [],
        };
    }
}
