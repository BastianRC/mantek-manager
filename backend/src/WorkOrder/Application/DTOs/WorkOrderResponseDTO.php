<?php

namespace Src\WorkOrder\Application\DTOs;

use Src\Location\Domain\Entity\Location;
use Src\Machine\Domain\Entities\Machine;
use Src\Machine\Domain\Entities\MachineCategory;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\ValueObject\WorkOrderCreatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderDueAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderEstimatedHours;
use Src\WorkOrder\Domain\ValueObject\WorkOrderPriority;
use Src\WorkOrder\Domain\ValueObject\WorkOrderStatus;
use Src\WorkOrder\Domain\ValueObject\WorkOrderNumber;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;

class WorkOrderResponseDTO extends BaseResponseDto
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
        public WorkOrderEstimatedHours $estimatedHours,
        public ?Machine $machine,
        public ?User $assignee,
        public Location $location,
        public WorkOrderCreatedAt $createdAt
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
                'priority' => $this->priority->value(),
                'status' => $this->status->value(),
                'assignee' => $this->assignee ? [
                    'id' => $this->assignee->getId(),
                    'name' => $this->assignee->getFullName(),
                    'avatar_url' => $this->assignee->getAvatarUrl(),
                ] : null,
                'machine' => $this->machine ? [
                    'id' => $this->machine->getId(),
                    'name' => $this->machine->getName(),
                    'category' => [
                        'id' => $this->machine->getCategory()->getId(),
                        'name' => $this->machine->getCategory()->getName()
                    ]
                ] : null,
                'location' => [
                    'id' => $this->location->getId(),
                    'name' => $this->location->getName(),
                ],
                'due_at' => $this->dueAt->toString(),
                'estimated_hours' => $this->estimatedHours->value(),
                'created_at' => $this->createdAt->toString(),
            ],
        ];
    }
}
