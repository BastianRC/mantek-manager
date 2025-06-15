<?php

namespace Src\Role\Infrastructure\Http\Controllers;

use Src\Role\Application\DTOs\UpdateRoleRequestDTO;
use Src\Role\Application\UseCases\UpdateRoleUseCase;
use Src\Role\Infrastructure\Http\Requests\UpdateRoleRequest;

class UpdateRoleController
{
    public function __invoke(int $id, UpdateRoleRequest $request, UpdateRoleUseCase $useCase)
    {
        $dto = new UpdateRoleRequestDTO(
            id: $id,
            name: $request->input('name'),
            description: $request->input('description'),
            color: $request->input('color'),
            isActive: $request->boolean('is_active'),
            permissions: $request->input('permissions'),
            updatedBy: $request->user()->id
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 200);
    }
}
