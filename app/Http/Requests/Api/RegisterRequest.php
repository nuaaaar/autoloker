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
                Rule::in(['security', 'company', 'bujp']),
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
            'sio_number' => [
                'required_if:role,bujp',
                'string',
                'max:100',
            ],
            'sio_expired_date' => [
                'required_if:role,bujp',
                'date',
                'after:today',
            ],
            'sio_file' => [
                'required_if:role,bujp',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus security, company, atau bujp.',
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
            'sio_number.required_if' => 'Nomor SIO wajib diisi untuk bujp.',
            'sio_expired_date.required_if' => 'Tanggal berlaku SIO wajib diisi untuk bujp.',
            'sio_expired_date.after' => 'Tanggal berlaku SIO harus setelah hari ini.',
            'sio_file.required_if' => 'File SIO wajib diunggah untuk bujp.',
            'sio_file.mimes' => 'File SIO harus PDF, JPG, JPEG, atau PNG.',
            'sio_file.max' => 'Ukuran file SIO maksimal 5 MB.',
        ];
    }
}
