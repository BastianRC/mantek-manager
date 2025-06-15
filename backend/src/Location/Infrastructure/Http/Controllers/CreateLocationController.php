<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Src\Location\Application\DTOs\CreateLocationRequestDTO;
use Src\Location\Application\UseCases\CreateLocationUseCase;
use Src\Location\Infrastructure\Http\Requests\CreateLocationRequest;

class CreateLocationController
{
    public function __invoke(CreateLocationRequest $request, CreateLocationUseCase $useCase)
    {
        $dto = new CreateLocationRequestDTO(
            name: $request->input('name'),
            type: $request->input('type'),
            description: $request->input('description'),
            address: $request->input('address'),
            floor: $request->input('floor'),
            latitude: $request->input('latitude'),
            longitude: $request->input('longitude'),
            managerId: $request->input('manager_id'),
            emergencyContact: $request->input('emergency_contact'),
            emergencyPhone: $request->input('emergency_phone'),
            accessRequirements: $request->input('access_requirements'),
            operatingHours: $request->input('operating_hours'),
            notes: $request->input('notes'),
            isActive: $request->boolean('is_active', true),
            zones: $request->input('zones'),
            systems: $request->input('systems'),
            createdBy: $request->user()->id
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}
