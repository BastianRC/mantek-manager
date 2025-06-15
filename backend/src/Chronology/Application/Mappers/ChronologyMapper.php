<?php

namespace Src\Chronology\Application\Mappers;

use Src\Chronology\Application\DTOs\AllChronologiesResponseDTO;
use Src\Chronology\Application\DTOs\ChronologyResponseDTO;
use Src\Chronology\Domain\Entities\Chronology;

class ChronologyMapper
{
    public static function toDto(Chronology $chronology, string $message = 'Cronología obtenido correctamente.'): ChronologyResponseDTO
    {
        return new ChronologyResponseDTO(
            success: true,
            message: $message,
            id: $chronology->getId(),
            user: $chronology->getUser(),
            targetType: $chronology->getTargetType(),
            targetId: $chronology->getTargetId(),
            eventType: $chronology->getEventType(),
            description: $chronology->getDescription(),
            meta: $chronology->getMeta(),
            createdAt: $chronology->getCreatedAt()
        );
    }

    /**
     * @param Chronology[] $events
     */
    public static function toCollectionDto(array $chronologies, string $message = 'Cronología obtenida correctamente.'): AllChronologiesResponseDTO
    {
        $dtos = array_map(
            fn(Chronology $event) => self::toDto($event),
            $chronologies
        );

        return new AllChronologiesResponseDTO(
            success: true,
            message: $message,
            chronologies: $dtos
        );
    }
}
