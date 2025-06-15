<?php

namespace Src\Machine\Infrastructure\Http\Controllers;

use Src\Machine\Application\DTOs\CreateMachineCategoryRequestDTO;
use Src\Machine\Application\UseCases\CreateMachineCategoryUseCase;
use Src\Machine\Infrastructure\Http\Requests\CreateMachineCategoryRequest;

class CreateMachineCategoryController
{
    public function __invoke(CreateMachineCategoryRequest $request, CreateMachineCategoryUseCase $useCase)
    {
        $dto = new CreateMachineCategoryRequestDTO(
            name: $request->input('name'),
            createdById: $request->user()->id
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}
