<?php

namespace Src\Shared\Infrastructure\Services;

use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use Src\Chronology\Domain\Entities\ChronologyEntity;
use Src\Chronology\Domain\Repositories\ChronologyRepositoryInterface;
use Src\Chronology\Domain\ValueObject\ChronologyCreatedAt;

use Src\Chronology\Domain\ValueObject\ChronologyEventType;
use Src\Chronology\Domain\ValueObject\ChronologyMeta;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;
use Src\User\Domain\Entity\User;
use Src\User\Domain\Repositories\UserRepositoryInterface;

class ChronologyLoggerService implements ChronologyLoggerInterface
{
    public function __construct(
        private readonly ChronologyRepositoryInterface $repo
    ) {}

    public function log(
        User|int|null $user,
        string $targetType,
        int $targetId,
        string $eventType,
        ?string $description = null,
        ?array $meta = null
    ): void {
        if (!$user && Auth::check()) {
            $user = Auth::id();
        }

        $user = $user ? $this->resolveUser($user) : null;

        $chronology = new ChronologyEntity(
            id: 0,
            user: $user,
            targetType: new ChronologyTargetType($targetType),
            targetId: $targetId,
            eventType: new ChronologyEventType($eventType),
            description: $description,
            meta: $meta ? new ChronologyMeta($meta) : null,
            createdAt: new ChronologyCreatedAt(new DateTimeImmutable())
        );

        $this->repo->create($chronology);
    }

    private function resolveUser(User|int|null $user): ?User
    {
        if ($user instanceof User) {
            return $user;
        }

        if (is_int($user)) {
            return app(UserRepositoryInterface::class)->findById($user);
        }

        return null;
    }
}
