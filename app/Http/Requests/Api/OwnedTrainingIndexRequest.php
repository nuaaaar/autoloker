<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OwnedTrainingIndexRequest extends FormRequest
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
                'draft',
                'rejected',
                'submitted',
                'published',
                'closed',
                'running',
                'cancelled',
            ])],
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
