<?php

namespace Src\Machine\Application\UseCases;

use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Machine\Application\DTOs\CreateMachineRequestDTO;
use Src\Machine\Application\DTOs\MachineDetailsResponseDTO;
use Src\Machine\Application\Mappers\MachineMapper;
use Src\Machine\Domain\Entities\MachineEntity;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineCreatedAt;
use Src\Machine\Domain\ValueObject\MachineInstalledAt;
use Src\Machine\Domain\ValueObject\MachineStatus;
use Src\Machine\Domain\ValueObject\MachineUpdatedAt;

use Src\Machine\Domain\ValueObject\MachineWarrantyAt;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class CreateMachineUseCase
{
    public function __construct(
        private MachineRepositoryInterface $machineRepo,
        private MachineTypeRepositoryInterface $typeRepo,
        private MachineCategoryRepositoryInterface $categoryRepo,
        private LocationRepositoryInterface $locationRepo,
        private UserRepositoryInterface $userRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(CreateMachineRequestDTO $dto): MachineDetailsResponseDTO
    {
        $type = $this->typeRepo->findById($dto->typeId);
        $category = $this->categoryRepo->findById($dto->categoryId);
        $location = $this->locationRepo->findById($dto->locationId);
        $creator = $this->userRepo->findById($dto->createdById);

        $machine = new MachineEntity(
            id: 0,
            name: $dto->name,
            type: $type,
            category: $category,
            model: $dto->machineModel,
            serialNumber: $dto->serialNumber,
            manufacturer: $dto->manufacturer,
            location: $location,
            workOrders: [],
            description: $dto->description,
            installDate: new MachineInstalledAt($dto->installDate),
            warrantyExpiry: new MachineWarrantyAt($dto->warrantyExpiry),
            supplier: $dto->supplier,
            operatingTemperatureMin: $dto->operatingTemperatureMin,
            operatingTemperatureMax: $dto->operatingTemperatureMax,
            operatingPressureMax: $dto->operatingPressureMax,
            powerConsumption: $dto->powerConsumption,
            voltage: $dto->voltage,
            frequency: $dto->frequency,
            weight: $dto->weight,
            dimensions: $dto->dimensions,
            maintenanceIntervalDays: $dto->maintenanceIntervalDays,
            status: new MachineStatus($dto->status),
            notes: $dto->notes,
            createdBy: $creator,
            updatedBy: $creator,
            createdAt: new MachineCreatedAt(),
            updatedAt: new MachineUpdatedAt()
        );

        $created = $this->machineRepo->create($machine);

        $this->chronologyLogger->log(
            user: $creator,
            targetType: 'machine',
            targetId: $created->getId(),
            eventType: 'created',
            description: 'Máquina creada',
            meta: [
                'name' => $created->getName(),
                'type' => $created->getType()->getName(),
            ]
        );

        return MachineMapper::toDetailsDto($created, 'Machine created successfully.');
    }
}
