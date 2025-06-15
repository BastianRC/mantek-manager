<?php

namespace Src\User\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;
use Src\User\Domain\Repositories\UserRepositoryInterface;
use Src\User\Infrastructure\Repositories\UserEloquentRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
    }
}