<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SecurityCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'satpam';
    }

    public function rules(): array
    {
        $required = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'title' => [$required, 'nullable', 'string', 'max:255'],
            'publisher' => [$required, 'nullable', 'string', 'max:255'],
            'certificate_number' => [$required, 'nullable', 'string', 'max:255'],
            'category' => [$required, 'nullable', 'string', Rule::exists('master_category_certificates', 'title')->whereNull('deleted_at')],
            'publish_date' => [$required, 'nullable', 'date'],
            'expired_date' => [$required, 'nullable', 'date', 'after_or_equal:publish_date'],
            'file' => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'is_badge' => ['sometimes', 'boolean'],
        ];
    }
}
