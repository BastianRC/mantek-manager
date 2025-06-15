<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Application\DTOs\CreateLocationRequestDTO;
use Src\Location\Application\DTOs\LocationDetailsResponseDTO;
use Src\Location\Application\DTOs\LocationResponseDTO;
use Src\Location\Application\Mappers\LocationMapper;
use Src\Location\Domain\Entity\LocationEntity;
use Src\Location\Domain\Entity\LocationSystemEntity;
use Src\Location\Domain\Entity\LocationZoneEntity;
use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Location\Domain\ValueObject\LocationCreatedAt;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Exceptions\UserNotFoundException;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class CreateLocationUseCase
{
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepo,
        private readonly UserRepositoryInterface $userRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(CreateLocationRequestDTO $dto): LocationResponseDTO
    {
        $createdBy = $this->userRepo->findById($dto->createdBy);
        throw_if(!$createdBy, UserNotFoundException::class);

        $manager = $this->userRepo->findById($dto->managerId);

        $location = new LocationEntity(
            id: 0,
            name: $dto->name,
            type: new LocationType($dto->type),
            description: $dto->description,
            address: $dto->address,
            floor: $dto->floor,
            latitude: $dto->latitude,
            longitude: $dto->longitude,
            manager: $manager,
            emergencyContact: $dto->emergencyContact,
            emergencyPhone: $dto->emergencyPhone,
            accessRequirements: $dto->accessRequirements,
            operatingHours: $dto->operatingHours,
            notes: $dto->notes,
            isActive: $dto->isActive,
            zones: $dto->zones ? array_map(
                fn($z) => new LocationZoneEntity(
                    id: 0,
                    zoneName: $z,
                    locationId: 0,
                ),
                $dto->zones
            ) : [],

            systems: $dto->systems ? array_map(
                fn($s) => new LocationSystemEntity(
                    id: 0,
                    locationId: 0,
                    systemType: new LocationSystemType($s)
                ),
                $dto->systems
            ) : [],
            machines: [],
            workOrders: [],
            createdBy: $createdBy,
            updatedBy: $createdBy,
            createdAt: new LocationCreatedAt(),
            updatedAt: new LocationUpdatedAt(),
        );

        $created = $this->locationRepo->create($location);

        $this->chronologyLogger->log(
            user: $createdBy,
            targetType: 'location',
            targetId: $created->getId(),
            eventType: 'created',
            description: 'Ubicación creada',
            meta: [
                'name' => $created->getName(),
                'type' => $created->getType()->value(),
            ]
        );

        return LocationMapper::toDto($created);
    }
}
