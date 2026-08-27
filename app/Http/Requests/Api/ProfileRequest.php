<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }
    protected function prepareForValidation(): void
    {
        if ($this->has('additional_notes') && ! $this->has('additional_note')) {
            $this->merge(['additional_note' => $this->input('additional_notes')]);
        }
    }
    public function rules(): array
    {
        $role = $this->user()?->role;
        $common = [
            'name' => ['sometimes', 'string', 'min:3', 'max:150'],
            'email' => ['sometimes', 'email:rfc,dns', 'max:100', Rule::unique('users', 'email')->ignore($this->user()?->id)],
            'phone_number' => ['sometimes', 'nullable', 'digits_between:10,15', Rule::unique('users', 'phone_number')->ignore($this->user()?->id)],
        ];

        if ($role === 'satpam') {
            return array_merge($common, [
                'formal_photo' => ['sometimes', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
                'birth_place' => ['sometimes', 'nullable', 'string', 'max:150'],
                'birth_date' => ['sometimes', 'nullable', 'date'],
                'gender' => ['sometimes', 'nullable', Rule::in(['laki-laki', 'perempuan'])],
                'address' => ['sometimes', 'nullable', 'string'],
                'ktp_number' => ['sometimes', 'nullable', 'string', 'max:50'],
                'registration_number' => ['sometimes', 'nullable', 'string', 'max:100'],
                'work_experience' => ['sometimes', 'nullable', 'string', 'max:100'],
                'province' => ['sometimes', 'nullable', 'exists:indonesia_provinces,code'],
                'city' => ['sometimes', 'nullable', 'exists:indonesia_cities,code'],
                'district' => ['sometimes', 'nullable', 'exists:indonesia_districts,code'],
                'village' => ['sometimes', 'nullable', 'exists:indonesia_villages,code'],
                'width' => ['sometimes', 'nullable', 'string', 'max:20'],
                'is_out_of_town_agree' => ['sometimes', 'boolean'],
                'is_shift_agree' => ['sometimes', 'boolean'],
                'ability' => ['sometimes', 'nullable', 'array'],
                'ability.*' => ['string', 'max:255', Rule::exists('master_abilities', 'title')->whereNull('deleted_at')],
                'placements' => ['sometimes', 'nullable', 'array'],
                'placements.*' => ['string', 'max:255', Rule::exists('master_placements', 'title')->whereNull('deleted_at')],
                'self_description' => ['sometimes', 'nullable', 'string'],
                'additional_note' => ['sometimes', 'nullable', 'string', 'max:500'],
                'work_status' => ['sometimes', 'nullable', 'string', 'max:100'],
                'company_name' => ['sometimes', 'nullable', 'string', 'max:255'],
                'position' => ['sometimes', 'nullable', 'string', 'max:150', Rule::exists('master_positions', 'title')->whereNull('deleted_at')],
                'sim' => ['sometimes', 'nullable', 'string', 'max:50'],
            ]);
        }

        $business = [
            'company_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'industry' => ['sometimes', 'nullable', 'string', 'max:255', Rule::exists('master_industries', 'title')->whereNull('deleted_at')],
            'logo' => ['sometimes', 'file', 'image', 'max:5120'],
            'description' => ['sometimes', 'nullable', 'string'],
            'npwp' => ['sometimes', 'nullable', 'string', 'max:50'],
            'nib' => ['sometimes', 'nullable', 'string', 'max:50'],
            'business_license' => ['sometimes', 'nullable', 'string', 'max:100'],
            'email' => ['sometimes', 'nullable', 'email:rfc,dns', 'max:100'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'website' => ['sometimes', 'nullable', 'url', 'max:255'],
            'province' => ['sometimes', 'nullable', 'exists:indonesia_provinces,code'],
            'city' => ['sometimes', 'nullable', 'exists:indonesia_cities,code'],
            'district' => ['sometimes', 'nullable', 'exists:indonesia_districts,code'],
            'village' => ['sometimes', 'nullable', 'exists:indonesia_villages,code'],
            'address' => ['sometimes', 'nullable', 'string'],
        ];

        foreach (['instagram', 'facebook', 'linkedin', 'youtube'] as $social) {
            $business[$social] = ['sometimes', 'nullable', 'url', 'max:255'];
        }

        if ($role === 'bujp') {
            $business['sio_number'] = ['sometimes', 'nullable', 'string', 'max:100'];
            $business['sio_expired_date'] = ['sometimes', 'nullable', 'date'];
            $business['sio_file'] = ['sometimes', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'];
        }

        return array_merge($common, $business);
    }
    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $locations = [
                'province' => new \Laravolt\Indonesia\Models\Province,
                'city' => new \Laravolt\Indonesia\Models\City,
                'district' => new \Laravolt\Indonesia\Models\District,
                'village' => new \Laravolt\Indonesia\Models\Village,
            ];
            $pairs = [
                ['province', 'city', 'province_code'],
                ['city', 'district', 'city_code'],
                ['district', 'village', 'district_code'],
            ];

            foreach ($pairs as [$parent, $child, $foreignKey]) {
                if ($this->filled($parent) && $this->filled($child)
                    && ! \DB::table($locations[$child]->getTable())
                        ->where('code', $this->input($child))
                        ->where($foreignKey, $this->input($parent))
                        ->exists()) {
                    $validator->errors()->add($child, 'The selected '.$child.' does not belong to the selected '.$parent.'.');
                }
            }
        });
    }
}
