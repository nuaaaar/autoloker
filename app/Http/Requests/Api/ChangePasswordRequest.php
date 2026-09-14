<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'current_password' => [
                Rule::requiredIf(fn (): bool => $this->user()?->has_local_password !== false),
                'nullable',
                'string',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'confirmed',
                'different:current_password',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'password.different' => 'Password baru harus berbeda dari password saat ini.',
            'password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, dan angka.',
        ];
    }
}
