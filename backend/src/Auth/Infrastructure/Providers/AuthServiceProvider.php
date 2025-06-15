<?php

namespace Src\Auth\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;
use Src\Auth\Domain\Repositories\AuthUserRepositoryInterface;
use Src\Auth\Infrastructure\Repositories\AuthUserSanctumRepository;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthUserRepositoryInterface::class, AuthUserSanctumRepository::class);
    }
}
