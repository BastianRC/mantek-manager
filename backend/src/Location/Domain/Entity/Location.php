<?php

namespace Src\Location\Domain\Entity;

use Src\Location\Domain\ValueObject\LocationCreatedAt;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\Machine\Domain\Entities\Machine;
use Src\User\Domain\Entity\User;
use Src\WorkOrder\Domain\Entities\WorkOrder;

interface Location
{
    public function getId(): int;
    public function getName(): string;
    public function getType(): LocationType;
    public function getDescription(): string;
    public function getAddress(): string;
    public function getFloor(): ?int;
    public function getLatitude(): ?float;
    public function getLongitude(): ?float;
    public function getOperatingHours(): ?string;
    public function getManager(): ?User;
    public function getEmergencyContact(): ?string;
    public function getEmergencyPhone(): ?string;
    public function getAccessRequirements(): ?string;
    public function getNotes(): ?string;
    public function isActive(): bool;
    public function isPersisted(): bool;
    public function getCreatedBy(): ?User;
    public function getUpdatedBy(): ?User;
    public function getCreatedAt(): LocationCreatedAt;
    public function getUpdatedAt(): LocationUpdatedAt;

    /** @return LocationZone[] */
    public function getZones(): array;

    /** @return LocationSystem[] */
    public function getSystems(): array;

    /** @return Machine[] */
    public function getMachines(): ?array;

    /** @return WorkOrder[] */
    public function getWorkOrders(): ?array;

    public function changeName(string $name): self;
    public function changeType(LocationType $type): self;
    public function changeDescription(string $description): self;
    public function changeAddress(string $address): self;
    public function changeFloor(?int $floor): self;
    public function changeLatitude(?float $latitude): self;
    public function changeLongitude(?float $longitude): self;
    public function changeOperatingHours(?string $hours): self;
    public function changeManager(?User $manager): self;
    public function changeEmergencyContact(?string $contact): self;
    public function changeEmergencyPhone(?string $phone): self;
    public function changeAccessRequirements(?string $requirements): self;
    public function changeNotes(?string $notes): self;
    public function changeStatus(bool $isActive): self;
    public function changeUpdatedBy(User $user): self;
    public function changeUpdatedAt(LocationUpdatedAt $updatedAt): self;
}
