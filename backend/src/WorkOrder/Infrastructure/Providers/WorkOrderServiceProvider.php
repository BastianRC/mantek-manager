<?php

namespace Src\WorkOrder\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\WorkOrder\Domain\Repositories\WorkOrderMaterialRepositoryInterface;
use Src\WorkOrder\Domain\Repositories\WorkOrderRepositoryInterface;
use Src\WorkOrder\Infrastructure\Repositories\WorkOrderEloquentRepository;
use Src\WorkOrder\Infrastructure\Repositories\WorkOrderMaterialEloquentRepository;

class WorkOrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WorkOrderRepositoryInterface::class, WorkOrderEloquentRepository::class);
    }
}
