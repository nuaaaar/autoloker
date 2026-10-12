<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GoogleAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $role = $this->input('role');
        if (is_string($role)) {
            $this->merge(['role' => Str::lower(trim($role))]);
        }
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', Rule::in(['security', 'cs', 'company'])],
            'id_token' => ['required', 'string', 'min:101', 'max:8192', 'regex:/^[A-Za-z0-9_-]+\\.[A-Za-z0-9_-]+\\.[A-Za-z0-9_-]+$/D'],
        ];
    }
}
