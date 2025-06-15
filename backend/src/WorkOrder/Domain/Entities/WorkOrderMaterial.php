<?php

namespace Src\WorkOrder\Domain\Entities;

use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialCreatedAt;
use Src\WorkOrder\Domain\ValueObject\WorkOrderMaterialUnit;

interface WorkOrderMaterial
{
    public function getId(): int;
    public function getMaterialName(): string;
    public function getQuantity(): float;
    public function getUnit(): WorkOrderMaterialUnit;
    public function getWorkOrderId(): int;

    public function isPersisted(): bool;

    public function changeMaterialName(string $name): self;
    public function changeQuantity(float $qty): self;
    public function changeUnit(WorkOrderMaterialUnit $unit): self;
}
