<?php

namespace Src\Location\Application\DTOs;

use Src\Location\Domain\ValueObject\LocationCreatedAt;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\Machine\Domain\Entities\Machine;
use Src\Shared\Application\DTOs\BaseResponseDto;

class LocationResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public LocationType $type,
        public string $description,
        public string $address,
        public ?string $managerName,
        public bool $isActive,
        public LocationCreatedAt $createdAt,
        public LocationUpdatedAt $updatedAt,

        /** @var Machines[] */
        public ?array $machines,

        /** @var WorkOrder[] */
        public ?array $workOrders,
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
                'type' => $this->type->value(),
                'description' => $this->description,
                'address' => $this->address,
                'manager_name' => $this->managerName,
                'is_active' => $this->isActive,
                'machines' => array_map(fn($m) => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'location' => $m->locationName,
                    'status' => $m->status
                ], $this->machines),
                'work_orders' => array_map(fn($w) => [
                    'id' => $w->id,
                    'order_number' => $w->orderNumber,
                    'name' => $w->name,
                    'status' => $w->status,
                    'asignee' => $w->asigneeName,
                    'created_at' => $w->createdAt,
                    'due_at' => $w->dueAt
                ], $this->workOrders),
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString(),
            ]
        ];
    }
}
