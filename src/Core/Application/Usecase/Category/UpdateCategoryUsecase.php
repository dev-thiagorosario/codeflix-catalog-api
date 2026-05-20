<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;
use App\Core\Application\Interfaces\Category\UpdateCategoryUsecaseInterface;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Exception\CategoryNotFoundException;

final class UpdateCategoryUsecase implements UpdateCategoryUsecaseInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateCategoryInputDTO $input): UpdateCategoryOutputDTO
    {
        $category = $this->repository->findById($input->id);

        if ($category === null) {
            throw new CategoryNotFoundException;
        }

        $category->update(
            $input->name,
            $input->description
        );

        if ($input->isActive !== null) {
            $input->isActive
                ? $category->activate()
                : $category->disable();
        }

        $categoryUpdated = $this->repository->update($category);

        return new UpdateCategoryOutputDTO(
            id: $categoryUpdated->id(),
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            isActive: $categoryUpdated->isActive,
            updatedAt: $categoryUpdated->updatedAt(),
        );
    }
}
