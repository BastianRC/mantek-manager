<?php

namespace Src\Location\Infrastructure\Mappers;

use Src\Location\Domain\Entity\Location;
use Src\Location\Domain\Entity\LocationEntity;
use Src\Location\Domain\Entity\LocationSystemEntity;
use Src\Location\Domain\Entity\LocationZoneEntity;
use Src\Location\Domain\ValueObject\LocationCreatedAt;
use Src\Location\Domain\ValueObject\LocationSystemType;
use Src\Location\Domain\ValueObject\LocationType;
use Src\Location\Domain\ValueObject\LocationUpdatedAt;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;
use Src\Machine\Domain\Entities\MachineEntity;
use Src\Machine\Domain\Entities\MachineRelationEntity;
use Src\User\Infrastructure\Mappers\UserEntityMapper;
use Src\WorkOrder\Domain\Entities\WorkOrderEntity;
use Src\WorkOrder\Domain\Entities\WorkOrderRelationEntity;

class LocationEntityMapper
{
    public static function toDomain(LocationEloquent $model): LocationEntity
    {
        return new LocationEntity(
            id: $model->id,
            name: $model->name,
            type: new LocationType($model->type),
            description: $model->description,
            address: $model->address,
            floor: $model->floor,
            latitude: $model->latitude,
            longitude: $model->longitude,
            manager: $model->manager ? UserEntityMapper::toDomain($model->manager) : null,
            emergencyContact: $model->emergency_contact,
            emergencyPhone: $model->emergency_phone,
            accessRequirements: $model->access_requirements,
            operatingHours: $model->operating_hours,
            notes: $model->notes,
            isActive: $model->is_active,
            zones: $model->zones
                ? array_map(fn($m) => new LocationZoneEntity(
                    id: $m->id,
                    locationId: $m->location_id,
                    zoneName: $m->zone_name,
                ), $model->zones->all())
                : [],
            systems: $model->systems
                ? array_map(fn($m) => new LocationSystemEntity(
                    id: $m->id,
                    locationId: $m->location_id,
                    systemType: new LocationSystemType($m->system_type),
                ), $model->systems->all())
                : [],
            machines: $model->machines
                ? $model->machines->map(fn($m) => new MachineRelationEntity(
                    id: $m->id,
                    name: $m->name,
                    locationName: $m->location->name,
                    type: $m->type->name,
                    status: $m->status,
                ))->all()
                : [],
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
            createdBy: $model->createdBy ? UserEntityMapper::toDomain($model->createdBy) : null,
            updatedBy: $model->updatedBy ? UserEntityMapper::toDomain($model->updatedBy) : null,
            createdAt: new LocationCreatedAt($model->created_at),
            updatedAt: new LocationUpdatedAt($model->updated_at),
        );
    }

    public static function toModel(LocationEntity $entity): LocationEloquent
    {
        $model = $entity->isPersisted()
            ? LocationEloquent::findOrFail($entity->getId())
            : new LocationEloquent();

        $model->name = $entity->getName();
        $model->type = $entity->getType()->value();
        $model->description = $entity->getDescription();
        $model->address = $entity->getAddress();
        $model->floor = $entity->getFloor();
        $model->latitude = $entity->getLatitude();
        $model->longitude = $entity->getLongitude();
        $model->manager_id = $entity->getManager()?->getId();
        $model->emergency_contact = $entity->getEmergencyContact();
        $model->emergency_phone = $entity->getEmergencyPhone();
        $model->access_requirements = $entity->getAccessRequirements();
        $model->operating_hours = $entity->getOperatingHours();
        $model->notes = $entity->getNotes();
        $model->is_active = $entity->isActive();

        $model->created_by = $entity->getCreatedBy()?->getId();
        $model->updated_by = $entity->getUpdatedBy()?->getId();

        $model->created_at = $entity->getCreatedAt()->value();
        $model->updated_at = $entity->getUpdatedAt()->value();

        return $model;
    }
}
