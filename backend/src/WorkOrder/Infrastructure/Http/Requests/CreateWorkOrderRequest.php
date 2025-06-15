<?php

namespace Src\WorkOrder\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;

class CreateWorkOrderRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:200'],
            'type' => ['required', Rule::in(WorkOrderType::validTypes())],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::in(WorkOrderPriority::validPriorities())],
            'status' => ['required', Rule::in(WorkOrderStatus::validStatuses())],
            'due_at' => ['required', 'date'],
            'paused_at' => ['nullable', 'date'],
            'started_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'estimated_hours' => ['required', 'numeric', 'min:0'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'machine_id' => ['nullable', 'integer', 'exists:machines,id'],
            'assignee_id' => ['nullable', 'integer', 'exists:users,id'],
            'requested_by' => ['nullable', 'string', 'max:200'],
            'approved_by' => ['nullable', 'string', 'max:200'],
            'notes' => ['nullable', 'string'],
            'materials' => ['nullable', 'array'],
            'materials.*.material_name' => ['required', 'string', 'max:200'],
            'materials.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'materials.*.unit' => ['required', Rule::in(WorkOrderMaterialUnit::validUnits())],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not be greater than 200 characters.',

            'type.required' => 'The type is required.',
            'type.in' => 'The selected type is invalid.',

            'description.required' => 'The description is required.',

            'priority.required' => 'The priority is required.',
            'priority.in' => 'The selected priority is invalid.',

            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid.',

            'due_at.required' => 'The due date is required.',
            'due_at.date' => 'The due date must be a valid date.',

            'paused_at.date' => 'The paused date must be a valid date.',
            'started_at.date' => 'The started date must be a valid date.',
            'completed_at.date' => 'The completed date must be a valid date.',

            'estimated_hours.required' => 'Estimated hours are required.',
            'estimated_hours.numeric' => 'Estimated hours must be a number.',
            'estimated_hours.min' => 'Estimated hours must be at least 0.',

            'location_id.required' => 'The location is required.',
            'location_id.exists' => 'The selected location does not exist.',

            'machine_id.exists' => 'The selected machine does not exist.',

            'assignee_id.exists' => 'The selected assignee does not exist.',

            'requested_by.max' => 'The requested by field may not be greater than 200 characters.',
            
            'approved_by.max' => 'The approved by field may not be greater than 200 characters.',

            'materials.*.material_name.required' => 'Material name is required.',
            'materials.*.quantity.required' => 'Material quantity is required.',
            'materials.*.unit.required' => 'Material unit is required.',
            'materials.*.unit.in' => 'Invalid material unit.',
        ];
    }
}
