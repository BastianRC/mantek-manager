<?php

namespace Src\User\Infrastructure\Http\Controllers;


use Src\User\Application\DTOs\AssignRoleToUserRequestDTO;
use Src\User\Application\UseCases\AssignRoleToUserUseCase;
use Src\User\Infrastructure\Http\Requests\AssignRoleToUserRequest;

class AssignRoleToUserController
{
    public function __invoke(AssignRoleToUserRequest $request, AssignRoleToUserUseCase $useCase)
    {
        $dto = new AssignRoleToUserRequestDto(...$request->validated());

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 200);
    }
    
}