<?php

namespace App\Http\Requests\Api;

use App\Services\Api\TrainingRules;
use Illuminate\Contracts\Validation\Validator;

class OwnedTrainingStoreRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = TrainingRules::normalizeArrayInputs($this->all());
        if (! $this->has('workflow_action')) {
            $data['workflow_action'] = 'save_draft';
        }

        $this->replace($data);
    }

    public function rules(): array
    {
        return array_merge(
            TrainingRules::create($this->hasFile('poster')),
            TrainingRules::immutable(),
        );
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            foreach (array_merge(
                TrainingRules::arrayErrors($this->all()),
                TrainingRules::dateErrors($this->all()),
                TrainingRules::locationErrors($this->all()),
            ) as $field => $messages) {
                foreach ($messages as $message) {
                    $validator->errors()->add($field, $message);
                }
            }
        });
    }
}
