<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\CreateMachineRequestDTO;
use Src\Machine\Application\UseCases\CreateMachineUseCase;
use Src\Machine\Infrastructure\Http\Requests\CreateMachineRequest;

class CreateMachineController
{
    public function __invoke(CreateMachineRequest $request, CreateMachineUseCase $useCase)
    {
        $dto = new CreateMachineRequestDTO(
            name: $request->input('name'),
            typeId: $request->input('type_id'),
            categoryId: $request->input('category_id'),
            machineModel: $request->input('machine_model'),
            serialNumber: $request->input('serial_number'),
            manufacturer: $request->input('manufacturer'),
            locationId: $request->input('location_id'),
            description: $request->input('description'),
            installDate: $request->input('install_date'),
            warrantyExpiry: $request->input('warranty_expiry'),
            supplier: $request->input('supplier'),
            operatingTemperatureMin: $request->input('operating_temperature_min'),
            operatingTemperatureMax: $request->input('operating_temperature_max'),
            operatingPressureMax: $request->input('operating_pressure_max'),
            powerConsumption: $request->input('power_consumption'),
            voltage: $request->input('voltage'),
            frequency: $request->input('frequency'),
            weight: $request->input('weight'),
            dimensions: $request->input('dimensions'),
            maintenanceIntervalDays: $request->input('maintenance_interval_days'),
            status: $request->input('status'),
            notes: $request->input('notes'),
            createdById: $request->user()->id
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}
