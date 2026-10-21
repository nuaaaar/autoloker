<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['satpam', 'cs', 'company', 'bujp'], true);
    }

    public function rules(): array
    {
        return ['confirm_delete' => ['required', function ($attribute, $value, $fail) {
            if ($value !== true) $fail('Konfirmasi penghapusan akun wajib bernilai true.');
        }]];
    }

    public function messages(): array
    {
        return ['confirm_delete.required' => 'Konfirmasi penghapusan akun wajib bernilai true.'];
    }
}
