<?php

namespace Src\Machine\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMachineCategoryRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The machine category name must be a string.',
            'name.max' => 'The machine category name must not exceed 255 characters.',
        ];
    }
}
