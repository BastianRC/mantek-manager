<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\UpdateMachineTypeRequestDTO;
use Src\Machine\Application\UseCases\UpdateMachineTypeUseCase;
use Src\Machine\Infrastructure\Http\Requests\UpdateMachineTypeRequest;

class UpdateMachineTypeController
{
    public function __invoke(int $id, UpdateMachineTypeRequest $request, UpdateMachineTypeUseCase $useCase)
    {
        $dto = new UpdateMachineTypeRequestDTO(
            id: $id,
            name: $request->input('name'),
            updatedById: $request->user()->id,
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 200);
    }
}
