<?php

namespace Src\Location\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Location\Domain\ValueObject\LocationSystemType;

class UpdateLocationRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:200'],
            'type' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'floor' => ['nullable', 'integer'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'manager_id' => ['nullable', 'integer', 'exists:users,id'],
            'emergency_contact' => ['nullable', 'string', 'max:200'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
            'access_requirements' => ['nullable', 'string'],
            'operating_hours' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'zones' => ['nullable', 'array'],
            'zones.*' => ['required', 'string'],
            'systems' => ['nullable', 'array'],
            'systems.*' => ['required', Rule::in(LocationSystemType::validTypes())],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'The name must not exceed 200 characters.',
            'floor.integer' => 'The floor must be an integer.',
            'latitude.numeric' => 'The latitude must be a number.',
            'longitude.numeric' => 'The longitude must be a number.',
            'manager_id.exists' => 'The selected manager is invalid.',
            'emergency_contact.max' => 'The emergency contact must not exceed 200 characters.',
            'emergency_phone.max' => 'The emergency phone must not exceed 20 characters.',
            'operating_hours.max' => 'The operating hours must not exceed 100 characters.',
            'is_active.boolean' => 'The active status must be true or false.',
            'zones.*.required' => 'Each zone must have a name.',
            'systems.*.required' => 'Each system must have a type.',
            'systems.*.in' => 'Invalid system type.'
        ];
    }
}
