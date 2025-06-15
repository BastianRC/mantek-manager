<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\UpdateMachineRequestDTO;
use Src\Machine\Application\UseCases\UpdateMachineUseCase;
use Src\Machine\Infrastructure\Http\Requests\UpdateMachineRequest;

class UpdateMachineController
{
    public function __invoke(int $id, UpdateMachineRequest $request, UpdateMachineUseCase $useCase)
    {
        $dto = new UpdateMachineRequestDTO(
            id: $id,
            name: $request->input('name'),
            typeId: $request->input('type_id'),
            categoryId: $request->input('category_id'),
            machineModel: $request->input('machine_model'),
            serialNumber: $request->input('serial_number'),
            manufacturer: $request->input('manufacturer'),
            locationId: $request->input('location_id'),
            description: $request->input('description') ?? '',
            installDate: $request->input('install_date'),
            warrantyExpiry: $request->input('warranty_expiry') ?? '',
            supplier: $request->input('supplier') ?? '',
            operatingTemperatureMin: $request->input('operating_temperature_min') ?? 0,
            operatingTemperatureMax: $request->input('operating_temperature_max') ?? 0,
            operatingPressureMax: $request->input('operating_pressure_max') ?? 0,
            powerConsumption: $request->input('power_consumption') ?? 0,
            voltage: $request->input('voltage') ?? 0,
            frequency: $request->input('frequency') ?? 0,
            weight: $request->input('weight') ?? 0,
            dimensions: $request->input('dimensions') ?? '',
            maintenanceIntervalDays: $request->input('maintenance_interval_days') ?? 0,
            status: $request->input('status'),
            notes: $request->input('notes') ?? '',
            updatedById: $request->user()->id,
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray());
    }
}
