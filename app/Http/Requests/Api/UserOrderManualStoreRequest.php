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
}
