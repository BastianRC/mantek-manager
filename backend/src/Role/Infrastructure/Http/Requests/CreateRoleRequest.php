<?php

namespace Src\Role\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Src\Role\Domain\ValueObject\RolePermission;

class CreateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'name'),
            ],
            'description' => ['required', 'string'],
            'color' => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The role name is required.',
            'name.string' => 'The role name must be a string.',
            'name.max' => 'The role name may not be greater than 100 characters.',
            'name.unique' => 'This role name already exists.',

            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',

            'color.string' => 'The color must be a string.',
            'color.max' => 'The color may not be greater than 20 characters.',

            'is_active.boolean' => 'The active status must be true or false.',

            'permissions.array' => 'Permissions must be an array.',
            'permissions.*.exists' => 'One or more permission IDs are invalid.',
        ];
    }
}
