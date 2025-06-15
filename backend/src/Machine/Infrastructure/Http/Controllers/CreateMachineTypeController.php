<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\CreateMachineTypeRequestDTO;
use Src\Machine\Application\UseCases\CreateMachineTypeUseCase;
use Src\Machine\Infrastructure\Http\Requests\CreateMachineTypeRequest;

class CreateMachineTypeController
{
    public function __invoke(CreateMachineTypeRequest $request, CreateMachineTypeUseCase $useCase)
    {
        $dto = new CreateMachineTypeRequestDTO(
            name: $request->input('name'),
            createdById: $request->user()->id,
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}