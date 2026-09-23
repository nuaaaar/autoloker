<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class OwnedJobApplicantStatusRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                'applied',
                'reviewed',
                'shortlisted',
                'rejected',
            ])],
        ];
    }
}
