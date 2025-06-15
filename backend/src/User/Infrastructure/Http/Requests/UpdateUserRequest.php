<?php

namespace Src\User\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UpdateUserRequest extends FormRequest
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
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[^A-Za-z0-9]/',
            ],
            'department' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'avatar_url' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
            'role' => [
                'nullable',
                'string',
                Rule::exists(Role::class, 'name'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name cannot exceed 100 characters.',

            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name cannot exceed 100 characters.',

            'email.email' => 'Email must be a valid address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email is already in use.',

            'phone.string' => 'Phone must be a string.',
            'phone.max' => 'Phone cannot exceed 20 characters.',

            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter and one symbol.',

            'department.string' => 'Department must be a string.',
            'department.max' => 'Department cannot exceed 100 characters.',

            'notes.string' => 'Notes must be a string.',
            'avatar_url.url' => 'Avatar URL must be a valid URL.',

            'is_active.boolean' => 'Active status must be true or false.',

            'role.string' => 'Role must be a string.',
            'role.exists' => 'The selected role does not exist.',
        ];
    }
}
