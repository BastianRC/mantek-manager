<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Src\User\Application\DTOs\CreateUserRequestDTO;
use Src\User\Application\UseCases\CreateUserUseCase;
use Src\User\Infrastructure\Http\Requests\CreateUserRequest;

class CreateUserController
{
    public function __invoke(CreateUserRequest $request, CreateUserUseCase $useCase)
    {
        $dto = new CreateUserRequestDto(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            password: $request->input('password'),
            department: $request->input('department'),
            notes: $request->input('notes'),
            avatarUrl: $request->input('avatar_url'),
            isActive: $request->input('is_active'),
            createdBy: $request->user()->id,
            role: $request->input('role')
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 201);
    }
}
