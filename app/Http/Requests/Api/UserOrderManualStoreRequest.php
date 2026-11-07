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
            'token_quantity' => ['required', 'integer', 'min:1', 'max:4294967295'],
        ];
    }

    public function messages(): array
    {
        return [
            'token_quantity.required' => 'Jumlah token wajib diisi.',
            'token_quantity.integer' => 'Jumlah token harus berupa bilangan bulat.',
            'token_quantity.min' => 'Jumlah token minimal satu.',
        ];
    }
}
