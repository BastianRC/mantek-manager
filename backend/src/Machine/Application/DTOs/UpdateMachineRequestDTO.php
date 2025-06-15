<?php

namespace Src\Machine\Application\DTOs;

class UpdateMachineRequestDTO
{
    public function __construct(
        public int $id,
        public ?string $name,
        public ?int $typeId,
        public ?int $categoryId,
        public ?string $machineModel,
        public ?string $serialNumber,
        public ?string $manufacturer,
        public ?int $locationId,
        public ?string $description,
        public ?string $installDate,
        public ?string $warrantyExpiry,
        public ?string $supplier,
        public ?int $operatingTemperatureMin,
        public ?int $operatingTemperatureMax,
        public ?float $operatingPressureMax,
        public ?float $powerConsumption,
        public ?int $voltage,
        public ?int $frequency,
        public ?float $weight,
        public ?string $dimensions,
        public ?int $maintenanceIntervalDays,
        public ?string $status,
        public ?string $notes,
        public ?int $updatedById
    ) {}
}
