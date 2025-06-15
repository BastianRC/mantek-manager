<?php

namespace Src\Machine\Application\UseCases;

use Src\Machine\Application\Mappers\MachineCategoryMapper;
use Src\Machine\Domain\Repositories\MachineCategoryRepositoryInterface;

class GetMachineCategoriesListUseCase
{
    public function __construct(
        private readonly MachineCategoryRepositoryInterface $repo
    ) {}

    public function execute()
    {
        $categories = $this->repo->findAll();

        return MachineCategoryMapper::toCollectionDto($categories);
    }
}
