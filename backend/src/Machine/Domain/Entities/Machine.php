<?php

namespace Src\Machine\Domain\Entities;

use Src\Location\Domain\Entity\Location;
use Src\Machine\Domain\ValueObject\MachineCreatedAt;
use Src\Machine\Domain\ValueObject\MachineInstalledAt;
use Src\Machine\Domain\ValueObject\MachineNextMaintenanceAt;
use Src\Machine\Domain\ValueObject\MachineStatus;
use Src\Machine\Domain\ValueObject\MachineUpdatedAt;
use Src\Machine\Domain\ValueObject\MachineWarrantyAt;
use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\Entities\WorkOrder;

interface Machine
{
    public function getId(): int;
    public function getName(): string;
    public function getType(): MachineType;
    public function getCategory(): MachineCategory;
    public function getMachineModel(): string;
    public function getSerialNumber(): string;
    public function getManufacturer(): string;
    public function getLocation(): Location;
    
    /**
     * @return WorkOrder[]
     */
    public function getWorkOrders(): array;
    public function getDescription(): ?string;
    public function getInstallDate(): ?MachineInstalledAt;
    public function getNextMaintenance(): ?MachineNextMaintenanceAt;
    public function getWarrantyExpiry(): ?MachineWarrantyAt;
    public function getSupplier(): ?string;
    public function getOperatingTemperatureMin(): ?int;
    public function getOperatingTemperatureMax(): ?int;
    public function getOperatingPressureMax(): ?float;
    public function getPowerConsumption(): ?float;
    public function getVoltage(): ?int;
    public function getFrequency(): ?int;
    public function getWeight(): ?float;
    public function getDimensions(): ?string;
    public function getMaintenanceIntervalDays(): ?int;
    public function getStatus(): MachineStatus;
    public function getNotes(): ?string;
    public function getCreatedBy(): ?User;
    public function getUpdatedBy(): ?User;
    public function getCreatedAt(): MachineCreatedAt;
    public function getUpdatedAt(): MachineUpdatedAt;

    public function isPersisted(): bool;

    public function changeName(string $name): self;
    public function changeType(MachineType $type): self;
    public function changeCategory(MachineCategory $category): self;
    public function changeMachineModel(string $model): self;
    public function changeSerialNumber(string $serialNumber): self;
    public function changeManufacturer(string $manufacturer): self;
    public function changeLocation(Location $location): self;
    public function changeDescription(?string $description): self;
    public function changeInstallDate(?MachineInstalledAt $installDate): self;
    public function changeWarrantyExpiry(?MachineWarrantyAt $warrantyExpiry): self;
    public function changeSupplier(?string $supplier): self;
    public function changeOperatingTemperatureMin(?int $operatingTemperatureMin): self;
    public function changeOperatingTemperatureMax(?int $operatingTemperatureMax): self;
    public function changeOperatingPressureMax(?float $operatingPressureMax): self;
    public function changePowerConsumption(?float $powerConsumption): self;
    public function changeVoltage(?int $voltage): self;
    public function changeFrequency(?int $frequency): self;
    public function changeWeight(?float $weight): self;
    public function changeDimensions(?string $dimensions): self;
    public function changeMaintenanceIntervalDays(?int $maintenanceIntervalDays): self;
    public function changeStatus(MachineStatus $status): self;
    public function changeNotes(?string $notes): self;
    public function changeUpdatedBy(?User $updatedBy): self;
    public function changeUpdatedAt(MachineUpdatedAt $updatedAt): self;
}
