<?php

namespace Src\Machine\Infrastructure\Mappers;

use Src\Location\Infrastructure\Mappers\LocationEntityMapper;
use Src\Machine\Domain\Entities\MachineEntity;
use Src\Machine\Domain\ValueObject\MachineCreatedAt;
use Src\Machine\Domain\ValueObject\MachineInstalledAt;
use Src\Machine\Domain\ValueObject\MachineStatus;
use Src\Machine\Domain\ValueObject\MachineUpdatedAt;
use Src\Machine\Domain\ValueObject\MachineWarrantyAt;
use Src\Machine\Infrastructure\Persistence\Eloquent\Models\MachineEloquent;
use Src\User\Infrastructure\Mappers\UserEntityMapper;
use Src\WorkOrder\Domain\Entities\WorkOrderRelationEntity;

class MachineEntityMapper
{
    public static function toDomain(MachineEloquent $model): MachineEntity
    {
        return new MachineEntity(
            id: $model->id,
            name: $model->name,
            type: MachineTypeEntityMapper::toDomain($model->type),
            category: MachineCategoryEntityMapper::toDomain($model->category),
            model: $model->machine_model,
            serialNumber: $model->serial_number,
            manufacturer: $model->manufacturer,
            location: LocationEntityMapper::toDomain($model->location),
            workOrders: $model->workOrders
                ? $model->workOrders->map(fn($wo) => new WorkOrderRelationEntity(
                    id: $wo->id,
                    orderNumber: $wo->order_number,
                    name: $wo->title,
                    status: $wo->status,
                    type: $wo->type,
                    asigneeName: $wo->assignee?->first_name . ' ' . $wo->assignee?->last_name,
                    createdAt: $wo->created_at,
                    dueAt: $wo->due_at,
                ))->all()
                : [],
            description: $model->description,
            installDate: new MachineInstalledAt($model->install_date),
            warrantyExpiry: new MachineWarrantyAt($model->warranty_expiry),
            supplier: $model->supplier,
            operatingTemperatureMin: $model->operating_temperature_min,
            operatingTemperatureMax: $model->operating_temperature_max,
            operatingPressureMax: $model->operating_pressure_max,
            powerConsumption: $model->power_consumption,
            voltage: $model->voltage,
            frequency: $model->frequency,
            weight: $model->weight,
            dimensions: $model->dimensions,
            maintenanceIntervalDays: $model->maintenance_interval_days,
            status: new MachineStatus($model->status),
            notes: $model->notes,
            createdBy: $model->createdBy ? UserEntityMapper::toDomain($model->createdBy) : null,
            updatedBy: $model->updatedBy ? UserEntityMapper::toDomain($model->updatedBy) : null,
            createdAt: new MachineCreatedAt($model->created_at),
            updatedAt: new MachineUpdatedAt($model->updated_at)
        );
    }

    public static function toModel(MachineEntity $entity): MachineEloquent
    {
        $model = $entity->isPersisted()
            ? MachineEloquent::findOrFail($entity->getId())
            : new MachineEloquent();

        $model->name = $entity->getName();
        $model->type_id = $entity->getType()->getId();
        $model->category_id = $entity->getCategory()->getId();
        $model->machine_model = $entity->getMachineModel();
        $model->serial_number = $entity->getSerialNumber();
        $model->manufacturer = $entity->getManufacturer();
        $model->location_id = $entity->getLocation()->getId();
        $model->description = $entity->getDescription();
        $model->install_date = $entity->getInstallDate()->value();
        $model->warranty_expiry = $entity->getWarrantyExpiry()->value();
        $model->supplier = $entity->getSupplier();
        $model->operating_temperature_min = $entity->getOperatingTemperatureMin();
        $model->operating_temperature_max = $entity->getOperatingTemperatureMax();
        $model->operating_pressure_max = $entity->getOperatingPressureMax();
        $model->power_consumption = $entity->getPowerConsumption();
        $model->voltage = $entity->getVoltage();
        $model->frequency = $entity->getFrequency();
        $model->weight = $entity->getWeight();
        $model->dimensions = $entity->getDimensions();
        $model->maintenance_interval_days = $entity->getMaintenanceIntervalDays();
        $model->status = $entity->getStatus()->value();
        $model->notes = $entity->getNotes();

        $model->created_by = $entity->getCreatedBy()?->getId();
        $model->updated_by = $entity->getUpdatedBy()?->getId();

        $model->created_at = $entity->getCreatedAt()->value();
        $model->updated_at = $entity->getUpdatedAt()->value();

        return $model;
    }
}
