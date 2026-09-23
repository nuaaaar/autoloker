<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class OwnedTrainingParticipantStatusRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                'pending',
                'approved',
                'rejected',
            ])],
        ];
    }
}
