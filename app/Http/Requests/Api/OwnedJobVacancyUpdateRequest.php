<?php

namespace App\Http\Requests\Api;

use App\Services\Api\JobVacancyRules;
use Illuminate\Contracts\Validation\Validator;

class OwnedJobVacancyUpdateRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            JobVacancyRules::update(),
            JobVacancyRules::immutable(),
            ['workflow_action' => ['prohibited']],
        );
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            foreach (array_merge(
                JobVacancyRules::rangeErrors($this->all()),
                JobVacancyRules::locationErrors($this->all()),
            ) as $field => $messages) {
                foreach ($messages as $message) {
                    $validator->errors()->add($field, $message);
                }
            }
        });
    }
}
