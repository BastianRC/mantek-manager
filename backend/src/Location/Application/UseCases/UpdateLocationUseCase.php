<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Application\DTOs\LocationDetailsResponseDTO;
use Src\Location\Application\DTOs\UpdateLocationRequestDTO;
use Src\Location\Application\Mappers\LocationMapper;
use Src\Location\Domain\Entity\LocationSystemEntity;
use Src\Location\Domain\Entity\LocationZoneEntity;
use Src\Location\Domain\Exceptions\LocationNotFoundException;
use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class UpdateLocationUseCase
{
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepo,
        private readonly UserRepositoryInterface $userRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(UpdateLocationRequestDTO $dto): LocationDetailsResponseDTO
    {
        $location = $this->locationRepo->findById($dto->id);
        throw_if(!$location, LocationNotFoundException::class);

        $updatedLocation = $location;

        /* Log::debug('DTO values before map update', (array) $dto); */
        
        $map = [
            'name' => fn($l, $v) => $l->changeName($v),
            'type' => fn($l, $v) => $l->changeType(new LocationType($v)),
            'description' => fn($l, $v) => $l->changeDescription($v),
            'address' => fn($l, $v) => $l->changeAddress($v),
            'floor' => fn($l, $v) => $l->changeFloor($v),
            'latitude' => fn($l, $v) => $l->changeLatitude($v),
            'longitude' => fn($l, $v) => $l->changeLongitude($v),
            'managerId' => fn($l, $v) => $l->changeManager($this->userRepo->findById($v)),
            'emergencyContact' => fn($l, $v) => $l->changeEmergencyContact($v),
            'emergencyPhone' => fn($l, $v) => $l->changeEmergencyPhone($v),
            'accessRequirements' => fn($l, $v) => $l->changeAccessRequirements($v),
            'operatingHours' => fn($l, $v) => $l->changeOperatingHours($v),
            'notes' => fn($l, $v) => $l->changeNotes($v),
            'isActive' => fn($l, $v) => $l->changeStatus($v),
            'updatedBy'     => fn($l, $v) => $l->changeUpdatedBy($this->userRepo->findById($v)),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updatedLocation = $callback($updatedLocation, $dto->$key === '' ? null : $dto->$key);
            }
        }

        if (!is_null($dto->zones)) {
            $zones = array_map(fn($name) => new LocationZoneEntity(
                id: 0,
                locationId: $dto->id,
                zoneName: $name
            ), $dto->zones);

            $updatedLocation = $updatedLocation->changeZones($zones);
        }

        if (!is_null($dto->systems)) {
            $systems = array_map(fn($type) => new LocationSystemEntity(
                id: 0,
                locationId: $dto->id,
                systemType: new LocationSystemType($type)
            ), $dto->systems);

            $updatedLocation = $updatedLocation->changeSystems($systems);
        }

        $updatedLocation = $updatedLocation->changeUpdatedAt(new LocationUpdatedAt());

        $updated = $this->locationRepo->update($updatedLocation);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'user',
            targetId: $location->getId(),
            eventType: 'updated',
            description: 'Ubicación actualizada',
            meta: [
                'name' => $location->getName(),
                'type' => $location->getType()->value(),
            ]
        );

        return LocationMapper::toDetailsDto($updated, 'Location updated successfully.');
    }
}
