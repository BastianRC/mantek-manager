<?php

namespace Src\Role\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;
use Src\Role\Domain\Repositories\PermissionRepositoryInterface;
use Src\Role\Domain\Repositories\RoleRepositoryInterface;
use Src\Role\Infrastructure\Repositories\PermissionEloquentRepository;
use Src\Role\Infrastructure\Repositories\RoleEloquentRepository;

class RoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RoleRepositoryInterface::class, RoleEloquentRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionEloquentRepository::class);
    }
}