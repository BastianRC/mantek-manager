<?php

namespace Src\Location\Domain\Entity;

use Src\Location\Domain\ValueObject\LocationCreatedAt;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\User\Domain\Entity\User;

class LocationEntity implements Location
{
    public function __construct(
        private int $id,
        private string $name,
        private LocationType $type,
        private string $description,
        private string $address,
        private ?int $floor,
        private ?float $latitude,
        private ?float $longitude,
        private ?User $manager,
        private ?string $emergencyContact,
        private ?string $emergencyPhone,
        private ?string $accessRequirements,
        private ?string $operatingHours,
        private ?string $notes,
        private bool $isActive,
        private ?User $createdBy,
        private ?User $updatedBy,
        private LocationCreatedAt $createdAt,
        private LocationUpdatedAt $updatedAt,

        /** @var LocationZone[] */
        private ?array $zones,

        /** @var LocationSystem[] */
        private ?array $systems,

        /** @var Machine[] */
        private ?array $machines,

        /** @var WorkOrder[] */
        private ?array $workOrders
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getType(): LocationType
    {
        return $this->type;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
    public function getFloor(): ?int
    {
        return $this->floor;
    }
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
    public function getManager(): ?User
    {
        return $this->manager;
    }
    public function getEmergencyContact(): ?string
    {
        return $this->emergencyContact;
    }
    public function getEmergencyPhone(): ?string
    {
        return $this->emergencyPhone;
    }
    public function getAccessRequirements(): ?string
    {
        return $this->accessRequirements;
    }
    public function getOperatingHours(): ?string
    {
        return $this->operatingHours;
    }
    public function getNotes(): ?string
    {
        return $this->notes;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }
    public function getCreatedAt(): LocationCreatedAt
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): LocationUpdatedAt
    {
        return $this->updatedAt;
    }
    public function getZones(): array
    {
        return $this->zones;
    }
    public function getSystems(): array
    {
        return $this->systems;
    }
    public function getMachines(): ?array
    {
        return $this->machines;
    }
    public function getWorkOrders(): ?array
    {
        return $this->workOrders;
    }
    public function isPersisted(): bool
    {
        return $this->id > 0;
    }

    public function changeName(string $name): self
    {
        return $this->withClone(fn(self $clone) => $clone->name = $name);
    }

    public function changeType(LocationType $type): self
    {
        return $this->withClone(fn(self $clone) => $clone->type = $type);
    }

    public function changeDescription(string $description): self
    {
        return $this->withClone(fn(self $clone) => $clone->description = $description);
    }

    public function changeAddress(string $address): self
    {
        return $this->withClone(fn(self $clone) => $clone->address = $address);
    }

    public function changeFloor(?int $floor): self
    {
        return $this->withClone(fn(self $clone) => $clone->floor = $floor);
    }

    public function changeLatitude(?float $latitude): self
    {
        return $this->withClone(fn(self $clone) => $clone->latitude = $latitude);
    }

    public function changeLongitude(?float $longitude): self
    {
        return $this->withClone(fn(self $clone) => $clone->longitude = $longitude);
    }

    public function changeManager(?User $manager): self
    {
        return $this->withClone(fn(self $clone) => $clone->manager = $manager);
    }

    public function changeEmergencyContact(?string $contact): self
    {
        return $this->withClone(fn(self $clone) => $clone->emergencyContact = $contact);
    }

    public function changeEmergencyPhone(?string $phone): self
    {
        return $this->withClone(fn(self $clone) => $clone->emergencyPhone = $phone);
    }

    public function changeAccessRequirements(?string $req): self
    {
        return $this->withClone(fn(self $clone) => $clone->accessRequirements = $req);
    }

    public function changeOperatingHours(?string $hours): self
    {
        return $this->withClone(fn(self $clone) => $clone->operatingHours = $hours);
    }

    public function changeNotes(?string $notes): self
    {
        return $this->withClone(fn(self $clone) => $clone->notes = $notes);
    }

    public function changeStatus(bool $active): self
    {
        return $this->withClone(fn(self $clone) => $clone->isActive = $active);
    }

    public function changeUpdatedBy(?User $user): self
    {
        return $this->withClone(fn(self $clone) => $clone->updatedBy = $user);
    }

    public function changeUpdatedAt(LocationUpdatedAt $updatedAt): self
    {
        return $this->withClone(fn(self $clone) => $clone->updatedAt = $updatedAt);
    }

    public function changeZones(array $zones): self
    {
        return $this->withClone(fn(self $clone) => $clone->zones = $zones);
    }

    public function changeSystems(array $systems): self
    {
        return $this->withClone(fn(self $clone) => $clone->systems = $systems);
    }

    private function withClone(\Closure $callback): self
    {
        $clone = clone $this;
        $callback($clone);
        return $clone;
    }
}
