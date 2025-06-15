<?php

namespace Src\Machine\Application\DTOs;

use Src\Location\Domain\Entity\Location;
use Src\Machine\Domain\Entities\MachineCategory;
use Src\Machine\Domain\Entities\MachineType;
use Src\Machine\Domain\ValueObject\MachineCreatedAt;
use Src\Machine\Domain\ValueObject\MachineInstalledAt;
use Src\Machine\Domain\ValueObject\MachineStatus;
use Src\Machine\Domain\ValueObject\MachineUpdatedAt;
use Src\Machine\Domain\ValueObject\MachineWarrantyAt;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\Entities\WorkOrder;

class MachineDetailsResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public MachineType $type,
        public MachineCategory $category,
        public string $machineModel,
        public string $serialNumber,
        public string $manufacturer,
        public Location $location,

        /** @var WorkOrder[] */
        public ?array $workOrders,
        public ?string $description,
        public ?MachineInstalledAt $installDate,
        public ?MachineWarrantyAt $warrantyExpiry,
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
        public MachineStatus $status,
        public ?string $notes,
        public ?User $createdBy,
        public ?User $updatedBy,
        public MachineCreatedAt $createdAt,
        public MachineUpdatedAt $updatedAt,
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
                'name' => $this->name,
                'type' => $this->type ? [
                    'id' => $this->type->getId(),
                    'name' => $this->type->getName()
                ] : null,
                'category' => $this->category ? [
                    'id' => $this->category->getId(),
                    'name' => $this->category->getName()
                ] : null,
                'machine_model' => $this->machineModel,
                'serial_number' => $this->serialNumber,
                'manufacturer' => $this->manufacturer,
                'location' => [
                    'id' => $this->location->getId(),
                    'name' => $this->location->getName()
                ],
                'work_orders' => array_map(fn($w) => [
                    'id' => $w->id,
                    'order_number' => $w->orderNumber,
                    'name' => $w->name,
                    'status' => $w->status,
                    'type' => $w->type,
                    'asignee' => $w->asigneeName,
                    'created_at' => $w->createdAt,
                ], $this->workOrders ?? []),
                'description' => $this->description,
                'install_date' => $this->installDate->toString(),
                'warranty_expiry' => $this->warrantyExpiry->toString(),
                'supplier' => $this->supplier,
                'operating_temperature_min' => $this->operatingTemperatureMin,
                'operating_temperature_max' => $this->operatingTemperatureMax,
                'operating_pressure_max' => $this->operatingPressureMax,
                'power_consumption' => $this->powerConsumption,
                'voltage' => $this->voltage,
                'frequency' => $this->frequency,
                'weight' => $this->weight,
                'dimensions' => $this->dimensions,
                'maintenance_interval_days' => $this->maintenanceIntervalDays,
                'status' => $this->status->value(),
                'notes' => $this->notes,
                'created_by' => $this->createdBy ? [
                    'id' => $this->createdBy->getId(),
                    'name' => $this->createdBy->getFullName()
                ] : null,
                'updated_by' => $this->updatedBy ? [
                    'id' => $this->updatedBy->getId(),
                    'name' => $this->updatedBy->getFullName()
                ] : null,
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString()
            ]
        ];
    }
}
