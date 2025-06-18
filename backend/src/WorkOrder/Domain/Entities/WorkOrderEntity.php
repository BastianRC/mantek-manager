<?php

namespace Src\WorkOrder\Domain\Entities;

use Src\Location\Domain\Entity\Location;
use Src\Machine\Domain\Entities\Machine;
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
use Src\WorkOrder\Domain\ValueObject\WorkOrderResumedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderType;

class WorkOrderEntity implements WorkOrder
{
    public function __construct(
        private readonly int $id,
        private WorkOrderNumber $orderNumber,
        private string $title,
        private WorkOrderType $type,
        private string $description,
        private ?string $requestedBy,
        private ?string $approvedBy,
        private ?string $notes,
        private WorkOrderPriority $priority,
        private WorkOrderStatus $status,
        private WorkOrderDueAt $dueAt,
        private ?WorkOrderPausedAt $pausedAt,
        private ?WorkOrderStartedAt $startedAt,
        private ?WorkOrderCompletedAt $completedAt,
        private ?WorkOrderResumedAt $resumedAt,
        private WorkOrderEstimatedHours $estimatedHours,
        private ?float $actualHours,
        private ?Machine $machine,
        private ?User $assignee,
        private Location $location,

        /** @var WorkOrderMaterial[] */
        private array $materials,
        private User $createdBy,
        private ?User $updatedBy,
        private WorkOrderCreatedAt $createdAt,
        private WorkOrderUpdatedAt $updatedAt,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getOrderNumber(): WorkOrderNumber
    {
        return $this->orderNumber;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getType(): WorkOrderType
    {
        return $this->type;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getRequestedBy(): ?string
    {
        return $this->requestedBy;
    }
    public function getApprovedBy(): ?string
    {
        return $this->approvedBy;
    }
    public function getNotes(): ?string
    {
        return $this->notes;
    }
    public function getPriority(): WorkOrderPriority
    {
        return $this->priority;
    }
    public function getStatus(): WorkOrderStatus
    {
        return $this->status;
    }
    public function getDueAt(): WorkOrderDueAt
    {
        return $this->dueAt;
    }
    public function getPausedAt(): ?WorkOrderPausedAt
    {
        return $this->pausedAt;
    }
    public function getStartedAt(): ?WorkOrderStartedAt
    {
        return $this->startedAt;
    }
    public function getCompletedAt(): ?WorkOrderCompletedAt
    {
        return $this->completedAt;
    }
    public function getResumedAt(): ?WorkOrderResumedAt
    {
        return $this->resumedAt;
    }
    public function getEstimatedHours(): WorkOrderEstimatedHours
    {
        return $this->estimatedHours;
    }
    public function getActualHours(): ?float
    {
        return $this->actualHours;
    }
    public function getMachine(): ?Machine
    {
        return $this->machine;
    }
    public function getAssignee(): ?User
    {
        return $this->assignee;
    }
    public function getLocation(): Location
    {
        return $this->location;
    }
    /**
     * @return WorkOrderMaterial[]
     */
    public function getMaterials(): array
    {
        return $this->materials;
    }
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }
    public function getCreatedAt(): WorkOrderCreatedAt
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): WorkOrderUpdatedAt
    {
        return $this->updatedAt;
    }

    public function changeTitle(string $title): self
    {
        return $this->withClone(fn($cl) => $cl->title = $title);
    }

    public function changeType(WorkOrderType $type): self
    {
        return $this->withClone(fn($cl) => $cl->type = $type);
    }

    public function changeDescription(string $description): self
    {
        return $this->withClone(fn($cl) => $cl->description = $description);
    }

    public function changePriority(WorkOrderPriority $priority): self
    {
        return $this->withClone(fn($cl) => $cl->priority = $priority);
    }

    public function changeRequestedBy(?string $requestedBy): self
    {
        return $this->withClone(fn($cl) => $cl->requestedBy = $requestedBy);
    }

    public function changeApprovedBy(?string $approvedBy): self
    {
        return $this->withClone(fn($cl) => $cl->approvedBy = $approvedBy);
    }

    public function changeNotes(?string $notes): self
    {
        return $this->withClone(fn($cl) => $cl->notes = $notes);
    }

    public function changeStatus(WorkOrderStatus $status): self
    {
        return $this->withClone(fn($cl) => $cl->status = $status);
    }

    public function changeDueAt(WorkOrderDueAt $dueAt): self
    {
        return $this->withClone(fn($cl) => $cl->dueAt = $dueAt);
    }

    public function changePausedAt(?WorkOrderPausedAt $pausedAt): self
    {
        return $this->withClone(fn($cl) => $cl->pausedAt = $pausedAt);
    }

    public function changeStartedAt(?WorkOrderStartedAt $startedAt): self
    {
        return $this->withClone(fn($cl) => $cl->startedAt = $startedAt);
    }

    public function changeCompletedAt(?WorkOrderCompletedAt $completedAt): self
    {
        return $this->withClone(fn($cl) => $cl->completedAt = $completedAt);
    }

    public function changeResumedAt(?WorkOrderResumedAt $resumedAt): self
    {
        return $this->withClone(fn($cl) => $cl->resumedAt = $resumedAt);
    }

    public function changeEstimatedHours(WorkOrderEstimatedHours $estimatedHours): self
    {
        return $this->withClone(fn($cl) => $cl->estimatedHours = $estimatedHours);
    }

    public function changeActualHours(?float $actualHours): self
    {
        return $this->withClone(fn($cl) => $cl->actualHours = $actualHours);
    }

    public function changeMachine(?Machine $machine): self
    {
        return $this->withClone(fn($cl) => $cl->machine = $machine);
    }

    public function changeAssignee(User $assignee): self
    {
        return $this->withClone(fn($cl) => $cl->assignee = $assignee);
    }

    public function changeLocation(Location $location): self
    {
        return $this->withClone(fn($cl) => $cl->location = $location);
    }

    public function changeMaterials(array $materials): self
    {
        return $this->withClone(fn($clone) => $clone->materials = $materials);
    }


    public function changeUpdatedBy(User $updatedBy): self
    {
        return $this->withClone(fn($cl) => $cl->updatedBy = $updatedBy);
    }

    public function changeUpdatedAt(WorkOrderUpdatedAt $updatedAt): self
    {
        return $this->withClone(fn(self $clone) => $clone->updatedAt = $updatedAt);
    }

    public function isPersisted(): bool
    {
        return $this->id > 0;
    }

    public function isStarted(): bool
    {
        return $this->startedAt !== null;
    }

    public function isPaused(): bool
    {
        return $this->pausedAt !== null;
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
