<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\CreateCategoryInputDTO;
use App\Core\Application\DTO\Category\CreateCategoryOutputDTO;
use App\Core\Application\Interfaces\Usecase\Category\CreateCategoryUsecaseInterface;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;

final class CreateCategoryUsecase implements CreateCategoryUsecaseInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {}

    public function __invoke(CreateCategoryInputDTO $input): CreateCategoryOutputDTO
    {
        $category = new CategoryEntity(
            name: $input->name,
            description: $input->description,
            isActive: $input->isActive,
        );

        $categoryCreated = $this->categoryRepository->insert($category);

        return new CreateCategoryOutputDTO(
            id: $categoryCreated->id(),
            name: $categoryCreated->name,
            description: $categoryCreated->description,
            isActive: $categoryCreated->isActive,
            createdAt: $categoryCreated->createdAt(),
        );
    }
}
