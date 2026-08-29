<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SecurityHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'satpam';
    }

    public function rules(): array
    {
        return [
            'position' => ['sometimes', 'nullable', 'string'],
            'company_name' => ['sometimes', 'nullable', 'string'],
            'location' => ['sometimes', 'nullable', 'string'],
            'category' => ['sometimes', 'nullable', 'string', Rule::exists('master_placements', 'title')->whereNull('deleted_at')],
            'start_date' => ['sometimes', 'nullable', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date'],
            'description' => ['sometimes', 'nullable', 'string'],
            'is_current' => ['sometimes', 'boolean'],
        ];
    }
}
