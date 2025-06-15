<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\UpdateMachineCategoryRequestDTO;
use Src\Machine\Application\UseCases\UpdateMachineCategoryUseCase;
use Src\Machine\Infrastructure\Http\Requests\UpdateMachineCategoryRequest;

class UpdateMachineCategoryController
{
    public function __invoke(int $id, UpdateMachineCategoryRequest $request, UpdateMachineCategoryUseCase $useCase)
    {
        $dto = new UpdateMachineCategoryRequestDTO(
            id: $id,
            name: $request->input('name'),
            updatedById: $request->user()->id,
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray());
    }
}
