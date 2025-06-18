<?php

use Illuminate\Support\Facades\Route;
use Src\Auth\Infrastructure\Http\Controllers\LoginController;
use Src\Auth\Infrastructure\Http\Controllers\LogoutController;
use Src\Auth\Infrastructure\Http\Controllers\ValidateUserController;
use Src\Chronology\Infrastructure\Http\Controllers\GetChronologiesByUserIdController;
use Src\Chronology\Infrastructure\Http\Controllers\GetChronologiesListController;
use Src\Chronology\Infrastructure\Http\Controllers\GetChronologyByTargetController;
use Src\Location\Infrastructure\Http\Controllers\CreateLocationController;
use Src\Location\Infrastructure\Http\Controllers\DeleteLocationController;
use Src\Location\Infrastructure\Http\Controllers\GetLocationByIdController;
use Src\Location\Infrastructure\Http\Controllers\GetLocationsListController;
use Src\Location\Infrastructure\Http\Controllers\GetLocationSystemsListController;
use Src\Location\Infrastructure\Http\Controllers\GetLocationTypesListController;
use Src\Location\Infrastructure\Http\Controllers\UpdateLocationController;
use Src\Machine\Infrastructure\Http\Controllers\CreateMachineCategoryController;
use Src\Machine\Infrastructure\Http\Controllers\CreateMachineController;
use Src\Machine\Infrastructure\Http\Controllers\CreateMachineTypeController;
use Src\Machine\Infrastructure\Http\Controllers\DeleteMachineCategoryController;
use Src\Machine\Infrastructure\Http\Controllers\DeleteMachineController;
use Src\Machine\Infrastructure\Http\Controllers\DeleteMachineDocumentController;
use Src\Machine\Infrastructure\Http\Controllers\DeleteMachineTypeController;
use Src\Machine\Infrastructure\Http\Controllers\GetMachineByIdController;
use Src\Machine\Infrastructure\Http\Controllers\GetMachineCategoriesListController;
use Src\Machine\Infrastructure\Http\Controllers\GetMachineDocumentsByMachineController;
use Src\Machine\Infrastructure\Http\Controllers\GetMachinesListController;
use Src\Machine\Infrastructure\Http\Controllers\GetMachineTypesListController;
use Src\Machine\Infrastructure\Http\Controllers\UpdateMachineCategoryController;
use Src\Machine\Infrastructure\Http\Controllers\UpdateMachineController;
use Src\Machine\Infrastructure\Http\Controllers\UpdateMachineTypeController;
use Src\Machine\Infrastructure\Http\Controllers\UploadMachineDocumentController;
use Src\Role\Infrastructure\Http\Controllers\CreateRoleController;
use Src\Role\Infrastructure\Http\Controllers\DeleteRoleController;
use Src\Role\Infrastructure\Http\Controllers\GetPermissionsListController;
use Src\Role\Infrastructure\Http\Controllers\GetRoleByIdController;
use Src\Role\Infrastructure\Http\Controllers\GetRolesListController;
use Src\Role\Infrastructure\Http\Controllers\UpdateRoleController;
use Src\User\Infrastructure\Http\Controllers\AssignRoleToUserController;
use Src\User\Infrastructure\Http\Controllers\CreateUserController;
use Src\User\Infrastructure\Http\Controllers\DeleteUserController;
use Src\User\Infrastructure\Http\Controllers\GetUserByIdController;
use Src\User\Infrastructure\Http\Controllers\GetUsersListController;
use Src\User\Infrastructure\Http\Controllers\UpdateUserController;
use Src\WorkOrder\Infrastructure\Http\Controllers\CompleteWorkOrderController;
use Src\WorkOrder\Infrastructure\Http\Controllers\CreateWorkOrderController;
use Src\WorkOrder\Infrastructure\Http\Controllers\DeleteWorkOrderController;
use Src\WorkOrder\Infrastructure\Http\Controllers\GetWorkOrderByIdController;
use Src\WorkOrder\Infrastructure\Http\Controllers\GetWorkOrdersListController;
use Src\WorkOrder\Infrastructure\Http\Controllers\PauseWorkOrderController;
use Src\WorkOrder\Infrastructure\Http\Controllers\StartWorkOrderController;
use Src\WorkOrder\Infrastructure\Http\Controllers\UpdateWorkOrderController;

Route::prefix('auth')->group(function () {
    Route::post('/login', LoginController::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/validate', ValidateUserController::class);
        Route::post('/logout', LogoutController::class);
    });
});

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('/', GetUsersListController::class)->middleware('can:View all users');
    Route::get('/{id}', GetUserByIdController::class)->middleware('can:View user');
    Route::post('/', CreateUserController::class)->middleware('can:Create user');
    Route::patch('/{id}', UpdateUserController::class)->middleware('can:Update user');
    Route::delete('/{id}', DeleteUserController::class)->middleware('can:Delete user');

    Route::post('/assign-role', AssignRoleToUserController::class)->middleware('can:Assign role');
});

Route::prefix('roles')->middleware('auth:sanctum')->group(function () {
    Route::get('/', GetRolesListController::class)->middleware('can:View all roles');
    Route::get('/permissions', GetPermissionsListController::class)->middleware('can:View all permissions');
    Route::get('/{id}', GetRoleByIdController::class)->middleware('can:View role');
    Route::post('/', CreateRoleController::class)->middleware('can:Create role');
    Route::patch('/{id}', UpdateRoleController::class)->middleware('can:Update role');
    Route::delete('/{id}', DeleteRoleController::class)->middleware('can:Delete role');
});

Route::prefix('locations')->middleware('auth:sanctum')->group(function () {
    Route::get('/', GetLocationsListController::class)->middleware('can:View all locations');
    Route::get('/systems', GetLocationSystemsListController::class)->middleware('can:Create location');
    Route::get('/types', GetLocationTypesListController::class)->middleware('can:Create location');
    Route::get('/{id}', GetLocationByIdController::class)->middleware('can:View location');
    Route::post('/', CreateLocationController::class)->middleware('can:Create location');
    Route::patch('/{id}', UpdateLocationController::class)->middleware('can:Update location');
    Route::delete('/{id}', DeleteLocationController::class)->middleware('can:Delete location');
});

Route::prefix('machines')->middleware('auth:sanctum')->group(function () {
    Route::prefix('types')->group(function () {
        Route::get('/', GetMachineTypesListController::class)->middleware('can:View all machines');
        Route::post('/', CreateMachineTypeController::class)->middleware('can:Create machine');
        Route::patch('/{id}', UpdateMachineTypeController::class)->middleware('can:Update machine');
        Route::delete('/{id}', DeleteMachineTypeController::class)->middleware('can:Delete machine');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', GetMachineCategoriesListController::class)->middleware('can:View all machines');
        Route::post('/', CreateMachineCategoryController::class)->middleware('can:Create machine');
        Route::patch('/{id}', UpdateMachineCategoryController::class)->middleware('can:Update machine');
        Route::delete('/{id}', DeleteMachineCategoryController::class)->middleware('can:Delete machine');
    });

    Route::prefix('documents')->group(function () {
        Route::post('/', UploadMachineDocumentController::class)->middleware(['can:Create machine', 'can:Update machine']);
        Route::delete('/{id}', DeleteMachineDocumentController::class)->middleware('can:Delete machine');
    });
    Route::get('/{id}/documents', GetMachineDocumentsByMachineController::class)->middleware('can:View machine');

    Route::get('/', GetMachinesListController::class)->middleware('can:View all machines');
    Route::get('/{id}', GetMachineByIdController::class)->middleware('can:View machine');
    Route::post('/', CreateMachineController::class)->middleware('can:Create machine');
    Route::patch('/{id}', UpdateMachineController::class)->middleware('can:Update machine');
    Route::delete('/{id}', DeleteMachineController::class)->middleware('can:Delete machine');
});

Route::prefix('work-orders')->middleware('auth:sanctum')->group(function () {
    Route::get('/', GetWorkOrdersListController::class)->middleware('can:View all work orders');
    Route::get('/{id}', GetWorkOrderByIdController::class)->middleware('can:View work order');
    Route::post('/', CreateWorkOrderController::class)->middleware('can:Create work order');
    Route::patch('/{id}', UpdateWorkOrderController::class)->middleware('can:Update work order');
    Route::delete('/{id}', DeleteWorkOrderController::class)->middleware('can:Delete work order');

    Route::patch('/{id}/start', StartWorkOrderController::class)->middleware('can:Update work order');
    Route::patch('/{id}/pause', PauseWorkOrderController::class)->middleware('can:Update work order');
    Route::patch('/{id}/complete', CompleteWorkOrderController::class)->middleware('can:Update work order');
});

Route::prefix('chronologies')->middleware('auth:sanctum')->group(function () {
    Route::get('/', GetChronologiesListController::class)->middleware('can:View all chronologies');
    Route::get('/target/{type}/{id}', GetChronologyByTargetController::class)->middleware('can:View chronology');
    Route::get('/user/{id}', GetChronologiesByUserIdController::class)->middleware('can:View chronology');
});
