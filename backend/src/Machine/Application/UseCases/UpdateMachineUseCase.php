<?php

namespace Src\Machine\Application\UseCases;

use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Machine\Application\DTOs\UpdateMachineRequestDTO;
use Src\Machine\Application\Mappers\MachineMapper;
use Src\Machine\Domain\Exceptions\MachineNotFoundException;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Machine\Domain\ValueObject\MachineInstalledAt;
use Src\Machine\Domain\ValueObject\MachineStatus;
use Src\Machine\Domain\ValueObject\MachineUpdatedAt;
use Src\Machine\Domain\ValueObject\MachineWarrantyAt;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class UpdateMachineUseCase
{
    public function __construct(
        private MachineRepositoryInterface $machineRepo,
        private MachineTypeRepositoryInterface $typeRepo,
        private MachineCategoryRepositoryInterface $categoryRepo,
        private LocationRepositoryInterface $locationRepo,
        private UserRepositoryInterface $userRepo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(UpdateMachineRequestDTO $dto)
    {
        $machine = $this->machineRepo->findById($dto->id);
        throw_if(!$machine, MachineNotFoundException::class);

        $updatedMachine = $machine;

        $map = [
            'name' => fn($m, $v) => $m->changeName($v),
            'typeId' => fn($m, $v) => $m->changeType($this->typeRepo->findById($v)),
            'categoryId' => fn($m, $v) => $m->changeCategory($this->categoryRepo->findById($v)),
            'machineModel' => fn($m, $v) => $m->changeMachineModel($v),
            'serialNumber' => fn($m, $v) => $m->changeSerialNumber($v),
            'manufacturer' => fn($m, $v) => $m->changeManufacturer($v),
            'locationId' => fn($m, $v) => $m->changeLocation($this->locationRepo->findById($v)),
            'description' => fn($m, $v) => $m->changeDescription($v),
            'installDate' => fn($m, $v) => $m->changeInstallDate(new MachineInstalledAt($v)),
            'warrantyExpiry' => fn($m, $v) => $m->changeWarrantyExpiry(new MachineWarrantyAt($v)),
            'supplier' => fn($m, $v) => $m->changeSupplier($v),
            'operatingTemperatureMin' => fn($m, $v) => $m->changeOperatingTemperatureMin($v),
            'operatingTemperatureMax' => fn($m, $v) => $m->changeOperatingTemperatureMax($v),
            'operatingPressureMax' => fn($m, $v) => $m->changeOperatingPressureMax($v),
            'powerConsumption' => fn($m, $v) => $m->changePowerConsumption($v),
            'voltage' => fn($m, $v) => $m->changeVoltage($v),
            'frequency' => fn($m, $v) => $m->changeFrequency($v),
            'weight' => fn($m, $v) => $m->changeWeight($v),
            'dimensions' => fn($m, $v) => $m->changeDimensions($v),
            'maintenanceIntervalDays' => fn($m, $v) => $m->changeMaintenanceIntervalDays($v),
            'status' => fn($m, $v) => $m->changeStatus(new MachineStatus($v)),
            'notes' => fn($m, $v) => $m->changeNotes($v),
            'updatedById' => fn($m, $v) => $m->changeUpdatedBy($this->userRepo->findById($v)),
        ];

        foreach ($map as $key => $callback) {
            if (!is_null($dto->$key)) {
                $updatedMachine = $callback($updatedMachine, $dto->$key === '' || $dto->$key === 0 ? null : $dto->$key);
            }
        }

        $updatedMachine = $updatedMachine->changeUpdatedAt(new MachineUpdatedAt());

        $updated = $this->machineRepo->update($updatedMachine);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'machine',
            targetId: $machine->getId(),
            eventType: 'updated',
            description: 'Máquina actualizada',
            meta: [
                'name' => $machine->getName(),
                'type' => $machine->getType()->getName(),
            ]
        );

        return MachineMapper::toDetailsDto($updated, 'Machine updated successfully.');
    }
}
