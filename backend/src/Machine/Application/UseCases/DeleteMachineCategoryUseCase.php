<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Domain\Exceptions\MachineCategoryNotFoundException;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;
use Src\Shared\Application\DTOs\BaseResponseDto;
use Src\Shared\Application\Mappers\ResponseMapper;

class DeleteMachineCategoryUseCase
{
    public function __construct(
        private readonly MachineCategoryRepositoryInterface $repo
    ) {}

    public function execute(int $id): BaseResponseDto
    {
        $category = $this->repo->findById($id);
        throw_if(!$category, MachineCategoryNotFoundException::class);

        $this->repo->delete($category);

        return ResponseMapper::toDto('Machine category deleted successfully.');
    }
}
