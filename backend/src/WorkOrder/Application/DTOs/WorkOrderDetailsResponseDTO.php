<?php

namespace Src\WorkOrder\Application\DTOs;

use Src\Location\Domain\Entity\Location;
use Src\Machine\Domain\Entities\Machine;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCompletedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCreatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderDueAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderEstimatedHours;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPausedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStartedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderUpdatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderNumber;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;

class WorkOrderDetailsResponseDTO extends BaseResponseDto
{
    public function __construct(
        public bool $success,
        public string $message,
        public int $id,
        public WorkOrderNumber $orderNumber,
        public string $title,
        public WorkOrderType $type,
        public string $description,
        public WorkOrderStatus $status,
        public WorkOrderPriority $priority,
        public WorkOrderDueAt $dueAt,
        public ?WorkOrderPausedAt $pausedAt,
        public ?WorkOrderStartedAt $startedAt,
        public ?WorkOrderCompletedAt $completedAt,
        public WorkOrderEstimatedHours $estimatedHours,
        public ?float $actualHours,
        public bool $isStarted,
        public bool $isPaused,
        public ?Machine $machine,
        public ?User $assignee,
        public Location $location,
        public ?string $requestedBy,
        public ?string $approvedBy,
        public ?string $notes,

        /** @var WorkOrderMaterial[] */
        public ?array $materials,
        public User $createdBy,
        public ?User $updatedBy,
        public WorkOrderCreatedAt $createdAt,
        public WorkOrderUpdatedAt $updatedAt
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'order_number' => $this->orderNumber->value(),
                'title' => $this->title,
                'type' => $this->type->value(),
                'description' => $this->description,
                'status' => $this->status->value(),
                'priority' => $this->priority->value(),
                'due_at' => $this->dueAt->toString(),
                'paused_at' => $this->pausedAt?->toString(),
                'started_at' => $this->startedAt?->toString(),
                'completed_at' => $this->completedAt?->toString(),
                'estimated_hours' => $this->estimatedHours->value(),
                'actual_hours' => $this->actualHours,
                'is_started' => $this->isStarted,
                'is_paused' => $this->isPaused,
                'machine' => $this->machine ? [
                    'id' => $this->machine->getId(),
                    'name' => $this->machine->getName(),
                    'category' => $this->machine->getCategory()
                ] : null,
                'assignee' => $this->assignee ? [
                    'id' => $this->assignee->getId(),
                    'name' => $this->assignee->getFullName(),
                    'avatar_url' => $this->assignee->getAvatarUrl(),
                ] : null,
                'location' => [
                    'id' => $this->location->getId(),
                    'name' => $this->location->getName(),
                ],
                'requested_by' => $this->requestedBy,
                'approved_by' => $this->approvedBy,
                'notes' => $this->notes,
                'materials' => array_map(fn($m) => [
                    'id' => $m->getId(),
                    'work_order_id' => $m->getWorkOrderId(),
                    'material_name' => $m->getMaterialName(),
                    'quantity' => $m->getQuantity(),
                    'unit' => $m->getUnit()->value(),
                ], $this->materials),
                'created_by' => [
                    'id' => $this->createdBy->getId(),
                    'name' => $this->createdBy->getFullName(),
                    'avatar_url' => $this->createdBy->getAvatarUrl(),
                ],
                'updated_by' =>$this->updatedBy ? [
                    'id' => $this->updatedBy->getId(),
                    'name' => $this->updatedBy->getFullName(),
                    'avatar_url' => $this->updatedBy->getAvatarUrl(),
                ] : null,
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt ? $this->updatedAt->toString() : null,
            ]
        ];
    }
}
