<?php

namespace Src\Location\Application\UseCases;

use Src\Location\Domain\Exceptions\LocationNotFoundException;
use Src\Location\Domain\Repository\LocationRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;
use Src\Shared\Domain\Repositories\ChronologyLoggerInterface;

class DeleteLocationUseCase
{
    public function __construct(
        private readonly LocationRepositoryInterface $repo,
        private ChronologyLoggerInterface $chronologyLogger
    ) {}

    public function execute(int $id): BaseResponseDto 
    {
        $location = $this->repo->findById($id);
        throw_if(!$location, LocationNotFoundException::class);

        $this->repo->delete($location);

        $this->chronologyLogger->log(
            user: null,
            targetType: 'location',
            targetId: $location->getId(),
            eventType: 'deleted',
            description: 'Ubicación eliminada',
            meta: []
        );


        return ResponseMapper::toDto('Location deleted succesfully.');
    }
}
