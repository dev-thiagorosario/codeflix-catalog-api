<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\CreateCategoryDTO;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;

class CreateCategoryUsecase implements CreateCategoryUsecaseInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ){}

    public function __invoke(CreateCategoryDTO $input): CategoryEntity
    {
            $category = new CategoryEntity(
                name: $input->name,
                description: $input->description,
                isActive: $input->isActive,
            );

            return $this->categoryRepository->insert($category);
    }
}
