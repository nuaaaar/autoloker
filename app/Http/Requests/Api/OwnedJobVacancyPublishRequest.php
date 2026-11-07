<?php

namespace App\Http\Requests\Api;

use App\Services\Api\JobVacancyRules;

class OwnedJobVacancyPublishRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return JobVacancyRules::publish();
    }
}
