<?php

namespace Src\Machine\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Machine\Domain\ValueObject\MachineStatus;

class UpdateMachineRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:200'],
            'type_id' => ['sometimes', 'integer', 'exists:machine_types,id'],
            'category_id' => ['sometimes', 'integer', 'exists:machine_categories,id'],
            'machine_model' => ['sometimes', 'string', 'max:200'],
            'serial_number' => ['sometimes', 'string', 'max:100'],
            'manufacturer' => ['sometimes', 'string', 'max:200'],
            'location_id' => ['sometimes', 'integer', 'exists:locations,id'],
            'description' => ['nullable', 'string'],
            'install_date' => ['nullable', 'date'],
            'warranty_expiry' => ['nullable', 'date'],
            'supplier' => ['nullable', 'string', 'max:200'],
            'operating_temperature_min' => ['nullable', 'integer'],
            'operating_temperature_max' => ['nullable', 'integer'],
            'operating_pressure_max' => ['nullable', 'numeric'],
            'power_consumption' => ['nullable', 'numeric'],
            'voltage' => ['nullable', 'integer'],
            'frequency' => ['nullable', 'integer'],
            'weight' => ['nullable', 'numeric'],
            'dimensions' => ['nullable', 'string', 'max:100'],
            'maintenance_interval_days' => ['nullable', 'integer'],
            'status' => ['sometimes', Rule::in(MachineStatus::validStatuses())],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'The name must not exceed 200 characters.',

            'type_id.integer' => 'The machine type must be a valid ID.',
            'type_id.exists' => 'The selected machine type does not exist.',

            'category_id.integer' => 'The machine category must be a valid ID.',
            'category_id.exists' => 'The selected machine category does not exist.',

            'machine_model.max' => 'The model must not exceed 200 characters.',
            'serial_number.max' => 'The serial number must not exceed 100 characters.',
            'manufacturer.max' => 'The manufacturer must not exceed 200 characters.',

            'location_id.integer' => 'The location must be a valid ID.',
            'location_id.exists' => 'The selected location does not exist.',

            'description.string' => 'The description must be a valid string.',
            'install_date.date' => 'The installation date must be a valid date.',
            'warranty_expiry.date' => 'The warranty expiry date must be a valid date.',
            'supplier.max' => 'The supplier must not exceed 200 characters.',

            'operating_temperature_min.integer' => 'The minimum temperature must be an integer.',
            'operating_temperature_max.integer' => 'The maximum temperature must be an integer.',
            'operating_pressure_max.numeric' => 'The maximum pressure must be a number.',
            'power_consumption.numeric' => 'The power consumption must be a number.',
            'voltage.integer' => 'The voltage must be an integer.',
            'frequency.integer' => 'The frequency must be an integer.',
            'weight.numeric' => 'The weight must be a number.',
            'dimensions.max' => 'The dimensions must not exceed 100 characters.',
            'maintenance_interval_days.integer' => 'The maintenance interval must be an integer.',

            'status.in' => 'The selected status is not valid.',
            'notes.string' => 'The notes must be a valid string.',
        ];
    }
}
