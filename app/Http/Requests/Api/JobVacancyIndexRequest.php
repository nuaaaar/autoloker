<?php

namespace App\Http\Requests\Api;

use App\Services\Api\JobVacancyRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobVacancyIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'nullable', 'string', 'max:255'],
            'province_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'working_type' => ['sometimes', 'nullable', Rule::in([
                'permanent',
                'contract',
                'intenrship',
                'freelance',
            ])],
            'working_system' => ['sometimes', 'nullable', Rule::in(JobVacancyRules::workingSystems())],
            'certificate' => ['sometimes', 'nullable', 'string', 'max:255'],
            'min_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'is_urgent' => ['sometimes', 'nullable', 'boolean'],
            'min_experience' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'gender' => ['sometimes', 'nullable', Rule::in(['laki-laki', 'perempuan'])],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
