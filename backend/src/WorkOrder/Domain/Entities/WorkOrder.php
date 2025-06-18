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

interface WorkOrder
{
    public function getId(): int;
    public function getOrderNumber(): WorkOrderNumber;
    public function getTitle(): string;
    public function getType(): WorkOrderType;
    public function getDescription(): string;
    public function getRequestedBy(): ?string;
    public function getApprovedBy(): ?string;
    public function getNotes(): ?string;
    public function getPriority(): WorkOrderPriority;
    public function getStatus(): WorkOrderStatus;
    public function getDueAt(): WorkOrderDueAt;
    public function getPausedAt(): ?WorkOrderPausedAt;
    public function getStartedAt(): ?WorkOrderStartedAt;
    public function getCompletedAt(): ?WorkOrderCompletedAt;
    public function getResumedAt(): ?WorkOrderResumedAt;
    public function getEstimatedHours(): WorkOrderEstimatedHours;
    public function getActualHours(): ?float;
    public function getMachine(): ?Machine;
    public function getAssignee(): ?User;
    public function getLocation(): Location;

    /**
     * @return WorkOrderMaterial[]
     */
    public function getMaterials(): array;
    public function getCreatedBy(): User;
    public function getUpdatedBy(): ?User;
    public function getCreatedAt(): WorkOrderCreatedAt;
    public function getUpdatedAt(): WorkOrderUpdatedAt;

    public function changeTitle(string $title): self;
    public function changeType(WorkOrderType $type): self;
    public function changeDescription(string $description): self;
    public function changeRequestedBy(?string $requestedBy): self;
    public function changeApprovedBy(?string $approvedBy): self;
    public function changeNotes(?string $notes): self;
    public function changePriority(WorkOrderPriority $priority): self;
    public function changeStatus(WorkOrderStatus $status): self;
    public function changeDueAt(WorkOrderDueAt $dueAt): self;
    public function changePausedAt(?WorkOrderPausedAt $pausedAt): self;
    public function changeStartedAt(?WorkOrderStartedAt $startedAt): self;
    public function changeCompletedAt(?WorkOrderCompletedAt $completedAt): self;
    public function changeResumedAt(?WorkOrderResumedAt $resumedAt): self;
    public function changeEstimatedHours(WorkOrderEstimatedHours $estimatedHours): self;
    public function changeActualHours(?float $actualHours): self;
    public function changeMachine(?Machine $machine): self;
    public function changeAssignee(User $assignee): self;
    public function changeLocation(Location $location): self;

    /**
     * @param WorkOrderMaterial[] $materials
     */
    public function changeMaterials(array $materials): self;
    public function changeUpdatedBy(User $updatedBy): self;
    public function changeUpdatedAt(WorkOrderUpdatedAt $updatedAt): self;

    public function isPersisted(): bool;
    public function isStarted(): bool;
    public function isPaused(): bool;
}
