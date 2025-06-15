<?php

namespace Src\Machine\Infrastructure\Providers;

use Carbon\Laravel\ServiceProvider;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineDocumentRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineRepositoryInterface;
use Src\Machine\Domain\Repositories\MachineTypeRepositoryInterface;
use Src\Machine\Infrastructure\Repositories\MachineCategoryEloquentRepository;
use Src\Machine\Infrastructure\Repositories\MachineDocumentEloquentRepository;
use Src\Machine\Infrastructure\Repositories\MachineEloquentRepository;
use Src\Machine\Infrastructure\Repositories\MachineTypeEloquentRepository;

class MachineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MachineRepositoryInterface::class, MachineEloquentRepository::class);
        $this->app->bind(MachineTypeRepositoryInterface::class, MachineTypeEloquentRepository::class);
        $this->app->bind(MachineCategoryRepositoryInterface::class, MachineCategoryEloquentRepository::class);
        $this->app->bind(MachineDocumentRepositoryInterface::class, MachineDocumentEloquentRepository::class);
    }
}
