<?php

namespace App\Http\Requests\Api;

class DeviceTokenRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'fcm_token' => ['required', 'string', 'max:4096'],
            'platform' => ['nullable', 'in:mobile,web'],
        ];
    }
}
