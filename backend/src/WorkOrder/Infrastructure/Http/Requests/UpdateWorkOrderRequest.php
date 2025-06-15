<?php

namespace Src\WorkOrder\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;

class UpdateWorkOrderRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:200'],
            'type' => ['nullable', Rule::in(WorkOrderType::validTypes())],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', Rule::in(WorkOrderPriority::validPriorities())],
            'status' => ['nullable', Rule::in(WorkOrderStatus::validStatuses())],
            'due_at' => ['nullable', 'date'],
            'paused_at' => ['nullable', 'date'],
            'started_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'estimated_hours' => ['nullable', 'numeric', 'min:0'],
            'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            'machine_id' => ['nullable', 'integer', 'exists:machines,id'],
            'assignee_id' => ['nullable', 'integer', 'exists:users,id'],
            'requested_by' => ['nullable', 'string', 'max:200'],
            'approved_by' => ['nullable', 'string', 'max:200'],
            'notes' => ['nullable', 'string'],
            'materials' => ['nullable', 'array'],
            'materials.*.id' => ['sometimes', 'integer'],
            'materials.*.material_name' => ['required_with:materials', 'string', 'max:200'],
            'materials.*.quantity' => ['required_with:materials', 'numeric', 'min:0'],
            'materials.*.unit' => ['required_with:materials', 'string', Rule::in(WorkOrderMaterialUnit::validUnits())],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'The title may not be greater than 200 characters.',
            'type.in' => 'The selected type is invalid.',
            'priority.in' => 'The selected priority is invalid.',
            'status.in' => 'The selected status is invalid.',
            'due_at.date' => 'The due date must be a valid date.',
            'paused_at.date' => 'The paused date must be a valid date.',
            'started_at.date' => 'The started date must be a valid date.',
            'completed_at.date' => 'The completed date must be a valid date.',
            'estimated_hours.numeric' => 'Estimated hours must be a number.',
            'estimated_hours.min' => 'Estimated hours must be at least 0.',
            'location_id.exists' => 'The selected location does not exist.',
            'machine_id.exists' => 'The selected machine does not exist.',
            'assignee_id.exists' => 'The selected assignee does not exist.',
            'requested_by.max' => 'The requested by field may not be greater than 200 characters.',
            'approved_by.max' => 'The approved by field may not be greater than 200 characters.',
            'materials.array' => 'Materials must be an array.',
            'materials.*.material_name.required_with' => 'Material name is required.',
            'materials.*.quantity.required_with' => 'Material quantity is required.',
            'materials.*.unit.required_with' => 'Material unit is required.',
            'materials.*.unit.in' => 'Invalid material unit.',
        ];
    }
}
