<?php

namespace Src\Role\Infrastructure\Http\Controllers;

use Src\Role\Application\UseCases\GetPermissionsListUseCase;

class GetPermissionsListController
{
    public function __invoke(GetPermissionsListUseCase $useCase)
    {
        $response = $useCase->execute();

        return response()->json($response->toArray(), 200);
    }
}