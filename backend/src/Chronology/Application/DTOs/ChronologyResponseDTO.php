<?php

namespace Src\Chronology\Application\DTOs;

use Src\Chronology\Domain\ValueObject\ChronologyCreatedAt;
use Src\Chronology\Domain\ValueObject\ChronologyMeta;
use Src\Chronology\Domain\ValueObject\ChronologyTargetType;
use Src\Chronology\Domain\ValueObject\ChronologyEventType;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\User\Domain\Entity\User;

class ChronologyResponseDTO extends BaseResponseDto
{
    public function __construct(
        bool $success,
        string $message,
        public int $id,
        public ?User $user,
        public ChronologyTargetType $targetType,
        public int $targetId,
        public ChronologyEventType $eventType,
        public ?string $description,
        public ?ChronologyMeta $meta,
        public ChronologyCreatedAt $createdAt
    ) {
        parent::__construct($success, $message);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => [
                'id' => $this->id,
                'user' => $this->user ? [
                    'id' => $this->user->getId(),
                    'name' => $this->user->getFullName(),
                ] : null,
                'target_type' => $this->targetType->value(),
                'target_id' => $this->targetId,
                'event_type' => $this->eventType->value(),
                'description' => $this->description,
                'meta' => $this->meta?->value(),
                'created_at' => $this->createdAt->toString(),
            ]
        ];
    }
}
