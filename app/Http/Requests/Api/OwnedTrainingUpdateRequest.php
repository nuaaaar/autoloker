<?php

namespace App\Http\Requests\Api;

use App\Services\Api\TrainingRules;
use Illuminate\Contracts\Validation\Validator;

class OwnedTrainingUpdateRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->replace(TrainingRules::normalizeArrayInputs($this->all()));
    }

    public function rules(): array
    {
        return array_merge(
            TrainingRules::update($this->hasFile('poster')),
            TrainingRules::immutable(),
            ['workflow_action' => ['prohibited']],
        );
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            foreach (TrainingRules::arrayErrors($this->all()) as $field => $messages) {
                foreach ($messages as $message) {
                    $validator->errors()->add($field, $message);
                }
            }
        });
    }
}
