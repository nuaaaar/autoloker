<?php

namespace App\Http\Requests\Api;

use App\Services\Api\RoleSwitchService;
use Illuminate\Validation\Rule;

class ChangeRoleRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->input('role'))) {
            $this->merge(['role' => strtolower(trim($this->input('role')))]);
        }
    }

    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(RoleSwitchService::ROLES)],
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Role wajib diisi.',
            'role.in' => 'Role harus security atau cs.',
        ];
    }
}
