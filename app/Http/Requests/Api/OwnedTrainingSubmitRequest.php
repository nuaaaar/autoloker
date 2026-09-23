<?php

namespace App\Http\Requests\Api;

use App\Services\Api\TrainingRules;

class OwnedTrainingSubmitRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return TrainingRules::submit();
    }
}
