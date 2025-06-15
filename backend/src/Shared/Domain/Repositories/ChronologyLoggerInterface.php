<?php

namespace Src\Shared\Domain\Repositories;

use Src\User\Domain\Entity\User;

interface ChronologyLoggerInterface
{
    public function log(
        ?User $user,
        string $targetType,
        int $targetId,
        string $eventType,
        ?string $description = null,
        ?array $meta = null
    ): void;
}
