<?php

namespace App\Http\Requests\Api;

class UserOrderManualStoreRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subscription_uuid' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'subscription_uuid.required' => 'Pilih paket langganan terlebih dahulu.',
            'subscription_uuid.string' => 'ID paket langganan tidak valid.',
        ];
    }
}
