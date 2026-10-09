<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->has('role')) {
            $data['role'] = strtolower(trim((string) $this->input('role')));
        }

        if ($this->has('email')) {
            $data['email'] = strtolower(trim((string) $this->input('email')));
        }

        if ($this->has('phone_number')) {
            $data['phone_number'] = preg_replace(
                '/[^0-9]/',
                '',
                (string) $this->input('phone_number')
            );
        }

        if ($data !== []) {
            $this->merge($data);
        }
    }

    public function rules(): array
    {
        return [
            'role' => [
                'required',
                Rule::in(['security', 'company']),
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:100',
                'unique:users,email',
            ],
            'phone_number' => [
                'nullable',
                'digits_between:10,15',
                'unique:users,phone_number',
                'required_if:role,security',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'agree' => [
                'accepted',
            ],
            'nib' => [
                'nullable',
                'string',
                'max:50',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus security atau company.',
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone_number.required_if' => 'Nomor WhatsApp wajib diisi untuk security.',
            'phone_number.digits_between' => 'Nomor WhatsApp harus 10–15 digit.',
            'phone_number.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            'agree.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
            'nib.required_if' => 'NIB wajib diisi untuk company.',
        ];
    }
}
