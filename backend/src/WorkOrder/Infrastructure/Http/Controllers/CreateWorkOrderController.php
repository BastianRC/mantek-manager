<?php

namespace Src\WorkOrder\Infrastructure\Http\Controllers;

use Src\WorkOrder\Application\DTOs\CreateWorkOrderRequestDTO;
use Src\WorkOrder\Application\UseCases\CreateWorkOrderUseCase;
use Src\WorkOrder\Infrastructure\Http\Requests\CreateWorkOrderRequest;

class CreateWorkOrderController
{
    public function __invoke(CreateWorkOrderRequest $request, CreateWorkOrderUseCase $useCase)
    {
        $dto = new CreateWorkOrderRequestDTO(
            title: $request->input('title'),
            type: $request->input('type'),
            description: $request->input('description'),
            priority: $request->input('priority'),
            status: $request->input('status'),
            dueAt: $request->input('due_at'),
            pausedAt: $request->input('paused_at'),
            startedAt: $request->input('started_at'),
            completedAt: $request->input('completed_at'),
            estimatedHours: $request->input('estimated_hours'),
            locationId: $request->input('location_id'),
            machineId: $request->input('machine_id'),
            assigneeId: $request->input('assignee_id'),
            requestedBy: $request->input('requested_by'),
            approvedBy: $request->input('approved_by'),
            notes: $request->input('notes'),
            materials: $request->input('materials'),
            createdBy: $request->user()->id,
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}
