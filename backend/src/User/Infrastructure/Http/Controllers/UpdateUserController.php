<?php

namespace Src\User\Infrastructure\Http\Controllers;

use Src\User\Application\DTOs\UpdateUserRequestDTO;
use Src\User\Application\UseCases\UpdateUserUseCase;
use Src\User\Infrastructure\Http\Requests\UpdateUserRequest;

class UpdateUserController
{
    public function __invoke(int $id, UpdateUserRequest $request, UpdateUserUseCase $useCase)
    {
        $dto = new UpdateUserRequestDto(
            id: $id,
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            password: $request->input('password'),
            department: $request->input('department'),
            notes: $request->input('notes') ?? '',
            avatarUrl: $request->input('avatar_url') ?? '',
            isActive: $request->input('is_active'),
            updatedBy: $request->user()->id,
            role: $request->input('role'),
        );

        $response = $useCase->execute($dto);

        return response()->json($response->toArray(), 200);
    }
}
