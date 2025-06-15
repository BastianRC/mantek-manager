<?php

namespace Src\Location\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Location\Domain\Entity\Location;
use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Location\Infrastructure\Mappers\LocationEntityMapper;
use Src\Location\Infrastructure\Persistence\Eloquent\Models\LocationEloquent;

class LocationEloquentRepository implements LocationRepositoryInterface
{
    public function findAll(): array
    {
        return LocationEloquent::with(['zones', 'systems', 'manager', 'machines.location', 'workOrders.assignee', 'createdBy', 'updatedBy'])
            ->get()
            ->map(fn($model) => LocationEntityMapper::toDomain($model))
            ->all();
    }

    public function findById(int $id): ?Location
    {
        $model = LocationEloquent::with(['zones', 'systems', 'manager', 'machines.location', 'workOrders.assignee', 'createdBy', 'updatedBy'])->find($id);
        return $model ? LocationEntityMapper::toDomain($model) : null;
    }

    public function create(Location $location): Location
    {
        $model = LocationEntityMapper::toModel($location);
        $model->save();

        foreach ($location->getZones() as $zone) {
            $model->zones()->create([
                'zone_name' => $zone->getZoneName(),
            ]);
        }

        foreach ($location->getSystems() as $systems) {
            $model->systems()->create([
                'system_type' => $systems->getSystemType()->value(),
            ]);
        }

        return LocationEntityMapper::toDomain($model);
    }

    public function update(Location $location): Location
    {
        $model = LocationEntityMapper::toModel($location);
        $model->save();

        DB::transaction(function () use ($model, $location) {
            $model->zones()->delete();

            foreach ($location->getZones() as $zone) {
                $model->zones()->create([
                    'zone_name' => $zone->getZoneName(),
                ]);
            }
        });

        DB::transaction(function () use ($model, $location) {
            $model->systems()->delete();

            foreach ($location->getSystems() as $systems) {
                $model->systems()->create([
                    'system_type' => $systems->getSystemType()->value(),
                ]);
            }
        });


        return LocationEntityMapper::toDomain($model);
    }

    public function delete(Location $location): void
    {
        $model = LocationEloquent::findOrFail($location->getId());
        $model->delete();
    }
}
