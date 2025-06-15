<?php

namespace Src\Role\Infrastructure\Http\Controllers;

use Src\Role\Application\DTOs\CreateRoleRequestDTO;
use Src\Role\Application\UseCases\CreateRoleUseCase;
use Src\Role\Infrastructure\Http\Requests\CreateRoleRequest;

class CreateRoleController
{
    public function __invoke(CreateRoleRequest $request, CreateRoleUseCase $useCase)
    {
        $dto = new CreateRoleRequestDTO(
            name: $request->input('name'),
            description: $request->input('description'),
            color: $request->input('color') ?? 'blue',
            isActive: $request->boolean('is_active', true),
            permissions: $request->input('permissions', []),
            createdBy: $request->user()->id
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}