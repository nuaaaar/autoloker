<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OwnedJobApplicantIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'nullable', Rule::in([
                'all',
                'applied',
                'reviewed',
                'shortlisted',
                'rejected',
            ])],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
