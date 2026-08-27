<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $identifier = trim((string) $this->input('identifier'));

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $identifier = Str::lower($identifier);
        } else {
            $identifier = preg_replace('/[^0-9]/', '', $identifier);
        }

        $this->merge([
            'role' => Str::lower(trim((string) $this->input('role'))),
            'identifier' => $identifier,
        ]);
    }

    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(['security', 'company', 'bujp'])],
            'identifier' => ['required', 'string', 'max:150'],
            'password' => ['required', 'string'],
        ];
    }
}
