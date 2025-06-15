<?php

namespace Src\WorkOrder\Domain\Entities;

use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialCreatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;

class WorkOrderMaterialEntity implements WorkOrderMaterial
{
    public function __construct(
        private int $id,
        private string $materialName,
        private float $quantity,
        private WorkOrderMaterialUnit $unit,
        private int $workOrderId,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getMaterialName(): string
    {
        return $this->materialName;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnit(): WorkOrderMaterialUnit
    {
        return $this->unit;
    }

    public function getWorkOrderId(): int
    {
        return $this->workOrderId;
    }

    public function isPersisted(): bool
    {
        return $this->id > 0;
    }

    public function changeMaterialName(string $name): self
    {
        return $this->withClone(fn($m) => $m->materialName = $name);
    }

    public function changeQuantity(float $qty): self
    {
        return $this->withClone(fn($m) => $m->quantity = $qty);
    }

    public function changeUnit(WorkOrderMaterialUnit $unit): self
    {
        return $this->withClone(fn($m) => $m->unit = $unit);
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
