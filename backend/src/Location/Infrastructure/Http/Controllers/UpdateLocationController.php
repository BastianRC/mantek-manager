<?php

namespace Src\Location\Infrastructure\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Src\Location\Application\DTOs\UpdateLocationRequestDTO;
use Src\Location\Application\UseCases\UpdateLocationUseCase;
use Src\Location\Infrastructure\Http\Requests\UpdateLocationRequest;

class UpdateLocationController
{
    public function __invoke(int $id, UpdateLocationRequest $request, UpdateLocationUseCase $useCase)
    {

        $dto = new UpdateLocationRequestDTO(
            id: $id,
            name: $request->input('name'),
            type: $request->input('type'),
            description: $request->input('description'),
            address: $request->input('address'),
            floor: $request->input('floor'),
            latitude: $request->input('latitude') ?? '',
            longitude: $request->input('longitude') ?? '',
            managerId: $request->input('manager_id'),
            emergencyContact: $request->input('emergency_contact') ?? '',
            emergencyPhone: $request->input('emergency_phone') ?? '',
            accessRequirements: $request->input('access_requirements') ?? '',
            operatingHours: $request->input('operating_hours') ?? '',
            notes: $request->input('notes') ?? '',
            isActive: $request->input('is_active'),
            zones: $request->input('zones'),
            systems: $request->input('systems'),
            updatedBy: $request->user()->id
        );

        Log::debug('DTO values before map update', (array) $dto); 

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 200);
    }
}
