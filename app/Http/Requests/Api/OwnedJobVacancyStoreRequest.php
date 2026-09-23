<?php

namespace App\Http\Requests\Api;

use App\Services\Api\JobVacancyRules;
use Illuminate\Contracts\Validation\Validator;

class OwnedJobVacancyStoreRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->has('workflow_action')) {
            $this->merge(['workflow_action' => 'save_draft']);
        }
    }

    public function rules(): array
    {
        return array_merge(
            JobVacancyRules::create(),
            JobVacancyRules::immutable(),
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
