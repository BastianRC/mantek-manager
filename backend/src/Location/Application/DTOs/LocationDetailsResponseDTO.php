<?php

namespace Src\Location\Application\DTOs;

use Src\Location\Domain\ValueObject\LocationCreatedAt;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\Machine\Domain\Entities\Machine;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\Entities\WorkOrder;

class LocationDetailsResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public string $name,
        public LocationType $type,
        public string $description,
        public string $address,
        public ?int $floor,
        public ?float $latitude,
        public ?float $longitude,
        public ?User $manager,
        public ?string $emergencyContact,
        public ?string $emergencyPhone,
        public ?string $accessRequirements,
        public ?string $operatingHours,
        public ?string $notes,
        public bool $isActive,
        public ?User $createdBy,
        public ?User $updatedBy,
        public LocationCreatedAt $createdAt,
        public LocationUpdatedAt $updatedAt,

        /** @var LocationZone[] */
        public array $zones,
        /** @var LocationSystem[] */
        public array $systems,

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
                'floor' => $this->floor,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'manager' => $this->manager ? [
                    'id' => $this->manager->getId(),
                    'name' => $this->manager->getFullName(),
                    'email' => $this->manager->getEmail()->value(),
                    'phone' => $this->manager->getPhone(),
                ] : null,
                'emergency_contact' => $this->emergencyContact,
                'emergency_phone' => $this->emergencyPhone,
                'access_requirements' => $this->accessRequirements,
                'operating_hours' => $this->operatingHours,
                'notes' => $this->notes,
                'is_active' => $this->isActive,
                'zones' => array_map(fn($z) => [
                    'id' => $z->getId(),
                    'name' => $z->getZoneName(),
                ], $this->zones),
                'systems' => array_map(fn($s) => [
                    'id' => $s->getId(),
                    'type' => $s->getSystemType()->value(),
                ], $this->systems),
                'machines' => array_map(fn($m) => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'location' => $m->locationName,
                    'type' => $m->type,
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
                'created_by' => $this->createdBy ? [
                    'id' => $this->createdBy->getId(),
                    'name' => $this->createdBy->getFullName(),
                ] : null,
                'updated_by' => $this->updatedBy ? [
                    'id' => $this->updatedBy->getId(),
                    'name' => $this->updatedBy->getFullName(),
                ] : null,
                'created_at' => $this->createdAt->toString(),
                'updated_at' => $this->updatedAt->toString(),
            ]
        ];
    }
}
