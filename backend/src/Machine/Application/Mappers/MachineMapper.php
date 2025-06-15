<?php

namespace Src\Machine\Application\Mappers;

use Src\Machine\Application\DTOs\AllMachinesResponseDTO;
use Src\Machine\Application\DTOs\MachineDetailsResponseDTO;
use Src\Machine\Application\DTOs\MachineResponseDTO;
use Src\Machine\Domain\Entities\Machine;

class MachineMapper
{
    public static function toDto(Machine $machine, string $message = 'Machine retrieved successfully.'): MachineResponseDTO
    {
        return new MachineResponseDTO(
            success: true,
            message: $message,
            id: $machine->getId(),
            name: $machine->getName(),
            type: $machine->getType(),
            category: $machine->getCategory(),
            location: $machine->getLocation(),
            manufacturer: $machine->getManufacturer(),
            machineModel: $machine->getMachineModel(),
            serialNumber: $machine->getSerialNumber(),
            supplier: $machine->getSupplier(),
            nextMaintenance: $machine->getNextMaintenance(),
            status: $machine->getStatus(),
            createdAt: $machine->getCreatedAt(),
            updatedAt: $machine->getUpdatedAt(),
        );
    }

    public static function toDetailsDto(Machine $machine, string $message = 'Machine details retrieved successfully.'): MachineDetailsResponseDTO
    {
        return new MachineDetailsResponseDTO(
            success: true,
            message: $message,
            id: $machine->getId(),
            name: $machine->getName(),
            type: $machine->getType(),
            category: $machine->getCategory(),
            machineModel: $machine->getMachineModel(),
            serialNumber: $machine->getSerialNumber(),
            manufacturer: $machine->getManufacturer(),
            location: $machine->getLocation(),
            workOrders: $machine->getWorkOrders(),
            description: $machine->getDescription(),
            installDate: $machine->getInstallDate(),
            warrantyExpiry: $machine->getWarrantyExpiry(),
            supplier: $machine->getSupplier(),
            operatingTemperatureMin: $machine->getOperatingTemperatureMin(),
            operatingTemperatureMax: $machine->getOperatingTemperatureMax(),
            operatingPressureMax: $machine->getOperatingPressureMax(),
            powerConsumption: $machine->getPowerConsumption(),
            voltage: $machine->getVoltage(),
            frequency: $machine->getFrequency(),
            weight: $machine->getWeight(),
            dimensions: $machine->getDimensions(),
            maintenanceIntervalDays: $machine->getMaintenanceIntervalDays(),
            status: $machine->getStatus(),
            notes: $machine->getNotes(),
            createdBy: $machine->getCreatedBy(),
            updatedBy: $machine->getUpdatedBy(),
            createdAt: $machine->getCreatedAt(),
            updatedAt: $machine->getUpdatedAt()
        );
    }

    /**
     * @param Machine[] $machines
     */
    public static function toCollectionDto(array $machines): AllMachinesResponseDTO
    {
        $dtos =  array_map(
            fn(Machine $machine) => self::toDto($machine),
            $machines
        );

        return new AllMachinesResponseDTO(
            success: true,
            message: 'Machines retrieved successfully.',
            machines: $dtos
        );
    }
}
