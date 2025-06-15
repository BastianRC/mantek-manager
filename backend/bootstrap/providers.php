<?php

return [
    App\Providers\AppServiceProvider::class,
    Src\Shared\Infrastructure\Providers\FileStorageServiceProvider::class,
    Src\Shared\Infrastructure\Providers\ChronologyLoggerServiceProvider::class,
    Src\Auth\Infrastructure\Providers\AuthServiceProvider::class,
    Src\User\Infrastructure\Providers\UserServiceProvider::class,
    Src\Role\Infrastructure\Providers\RoleServiceProvider::class,
    Src\Location\Infrastructure\Providers\LocationServiceProvider::class,
    Src\Machine\Infrastructure\Providers\MachineServiceProvider::class,
    Src\WorkOrder\Infrastructure\Providers\WorkOrderServiceProvider::class,
    Src\Chronology\Infrastructure\Providers\ChronologyServiceProvider::class
];
