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

class MachineEntity implements Machine
{
    public function __construct(
        private int $id,
        private string $name,
        private MachineType $type,
        private MachineCategory $category,
        private string $model,
        private string $serialNumber,
        private string $manufacturer,
        private Location $location,

        /** @var WorkOrder[] */
        private array $workOrders,
        private ?string $description,
        private ?MachineInstalledAt $installDate,
        private ?MachineWarrantyAt $warrantyExpiry,
        private ?string $supplier,
        private ?int $operatingTemperatureMin,
        private ?int $operatingTemperatureMax,
        private ?float $operatingPressureMax,
        private ?float $powerConsumption,
        private ?int $voltage,
        private ?int $frequency,
        private ?float $weight,
        private ?string $dimensions,
        private ?int $maintenanceIntervalDays,
        private MachineStatus $status,
        private ?string $notes,
        private ?User $createdBy,
        private ?User $updatedBy,
        private MachineCreatedAt $createdAt,
        private MachineUpdatedAt $updatedAt,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getType(): MachineType
    {
        return $this->type;
    }
    public function getCategory(): MachineCategory
    {
        return $this->category;
    }
    public function getMachineModel(): string
    {
        return $this->model;
    }
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }
    public function getLocation(): Location
    {
        return $this->location;
    }
    public function getWorkOrders(): array
    {
        return $this->workOrders;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getInstallDate(): ?MachineInstalledAt
    {
        return $this->installDate;
    }
    public function getNextMaintenance(): ?MachineNextMaintenanceAt
    {
        return $this->installDate && $this->maintenanceIntervalDays
            ? new MachineNextMaintenanceAt(
                $this->installDate->value()->add(
                    new \DateInterval("P{$this->maintenanceIntervalDays}D")
                )
            )
            : null;
    }
    public function getWarrantyExpiry(): ?MachineWarrantyAt
    {
        return $this->warrantyExpiry;
    }
    public function getSupplier(): ?string
    {
        return $this->supplier;
    }
    public function getOperatingTemperatureMin(): ?int
    {
        return $this->operatingTemperatureMin;
    }
    public function getOperatingTemperatureMax(): ?int
    {
        return $this->operatingTemperatureMax;
    }
    public function getOperatingPressureMax(): ?float
    {
        return $this->operatingPressureMax;
    }
    public function getPowerConsumption(): ?float
    {
        return $this->powerConsumption;
    }
    public function getVoltage(): ?int
    {
        return $this->voltage;
    }
    public function getFrequency(): ?int
    {
        return $this->frequency;
    }
    public function getWeight(): ?float
    {
        return $this->weight;
    }
    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }
    public function getMaintenanceIntervalDays(): ?int
    {
        return $this->maintenanceIntervalDays;
    }
    public function getStatus(): MachineStatus
    {
        return $this->status;
    }
    public function getNotes(): ?string
    {
        return $this->notes;
    }
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }
    public function getCreatedAt(): MachineCreatedAt
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): MachineUpdatedAt
    {
        return $this->updatedAt;
    }

    public function changeName(string $name): self
    {
        return $this->withClone(fn(self $clone) => $clone->name = $name);
    }

    public function changeType(MachineType $type): self
    {
        return $this->withClone(fn(self $clone) => $clone->type = $type);
    }

    public function changeCategory(MachineCategory $category): self
    {
        return $this->withClone(fn(self $clone) => $clone->category = $category);
    }

    public function changeMachineModel(string $model): self
    {
        return $this->withClone(fn(self $clone) => $clone->model = $model);
    }

    public function changeSerialNumber(string $serialNumber): self
    {
        return $this->withClone(fn(self $clone) => $clone->serialNumber = $serialNumber);
    }

    public function changeManufacturer(string $manufacturer): self
    {
        return $this->withClone(fn(self $clone) => $clone->manufacturer = $manufacturer);
    }

    public function changeLocation(Location $location): self
    {
        return $this->withClone(fn(self $clone) => $clone->location = $location);
    }

    public function changeDescription(?string $description): self
    {
        return $this->withClone(fn(self $clone) => $clone->description = $description);
    }

    public function changeInstallDate(?MachineInstalledAt $installDate): self
    {
        return $this->withClone(fn(self $clone) => $clone->installDate = $installDate);
    }

    public function changeWarrantyExpiry(?MachineWarrantyAt $warrantyExpiry): self
    {
        return $this->withClone(fn(self $clone) => $clone->warrantyExpiry = $warrantyExpiry);
    }

    public function changeSupplier(?string $supplier): self
    {
        return $this->withClone(fn(self $clone) => $clone->supplier = $supplier);
    }

    public function changeOperatingTemperatureMin(?int $operatingTemperatureMin): self
    {
        return $this->withClone(fn(self $clone) => $clone->operatingTemperatureMin = $operatingTemperatureMin);
    }

    public function changeOperatingTemperatureMax(?int $operatingTemperatureMax): self
    {
        return $this->withClone(fn(self $clone) => $clone->operatingTemperatureMax = $operatingTemperatureMax);
    }

    public function changeOperatingPressureMax(?float $operatingPressureMax): self
    {
        return $this->withClone(fn(self $clone) => $clone->operatingPressureMax = $operatingPressureMax);
    }

    public function changePowerConsumption(?float $powerConsumption): self
    {
        return $this->withClone(fn(self $clone) => $clone->powerConsumption = $powerConsumption);
    }

    public function changeVoltage(?int $voltage): self
    {
        return $this->withClone(fn(self $clone) => $clone->voltage = $voltage);
    }

    public function changeFrequency(?int $frequency): self
    {
        return $this->withClone(fn(self $clone) => $clone->frequency = $frequency);
    }

    public function changeWeight(?float $weight): self
    {
        return $this->withClone(fn(self $clone) => $clone->weight = $weight);
    }

    public function changeDimensions(?string $dimensions): self
    {
        return $this->withClone(fn(self $clone) => $clone->dimensions = $dimensions);
    }

    public function changeMaintenanceIntervalDays(?int $maintenanceIntervalDays): self
    {
        return $this->withClone(fn(self $clone) => $clone->maintenanceIntervalDays = $maintenanceIntervalDays);
    }

    public function changeStatus(MachineStatus $status): self
    {
        return $this->withClone(fn(self $clone) => $clone->status = $status);
    }

    public function changeNotes(?string $notes): self
    {
        return $this->withClone(fn(self $clone) => $clone->notes = $notes);
    }

    public function changeUpdatedBy(?User $updatedBy): self
    {
        return $this->withClone(fn(self $clone) => $clone->updatedBy = $updatedBy);
    }

    public function changeUpdatedAt(MachineUpdatedAt $updatedAt): self
    {
        return $this->withClone(fn(self $clone) => $clone->updatedAt = $updatedAt);
    }

    public function isPersisted(): bool
    {
        return $this->id > 0;
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
