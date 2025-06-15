<?php

namespace Src\Machine\Application\DTOs;

use Src\Location\Domain\Entity\Location;
use Src\Machine\Domain\Entities\MachineCategory;
use Src\Machine\Domain\Entities\MachineType;
use Src\Machine\Domain\ValueObject\MachineCreatedAt;
use Src\Machine\Domain\ValueObject\MachineNextMaintenanceAt;
use Src\Machine\Domain\ValueObject\MachineStatus;
use Src\Machine\Domain\ValueObject\MachineUpdatedAt;
use Src\Shared\Application\DTOs\BaseResponseDto;

class MachineResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public MachineType $type,
        public MachineCategory $category,
        public Location $location,
        public string $manufacturer,
        public string $machineModel,
        public string $serialNumber,
        public ?string $supplier,
        public ?MachineNextMaintenanceAt $nextMaintenance,
        public MachineStatus $status,
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
                'location' => $this->location ? [
                    'id' => $this->location->getId(),
                    'name' => $this->location->getName()
                ] : null,
                'manufacturer' => $this->manufacturer,
                'machine_model' => $this->machineModel,
                'serial_number' => $this->serialNumber,
                'supplier' => $this->supplier,
                'next_maintenance' => $this->nextMaintenance ? $this->nextMaintenance->toString() : null,
                'status' => $this->status->value(),
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString()
            ]
        ];
    }
}
