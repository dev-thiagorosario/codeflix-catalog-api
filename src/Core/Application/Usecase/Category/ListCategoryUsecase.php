<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\ListCategoryInputDTO;
use App\Core\Application\DTO\Category\ListCategoryOutputDTO;
use App\Core\Application\Interfaces\Usecase\Category\ListCategoryUsecaseInterface;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;

final class ListCategoryUsecase implements ListCategoryUsecaseInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {}

    public function __invoke(ListCategoryInputDTO $input): ListCategoryOutputDTO
    {
        $categories = $this->repository->paginate(
            filter: $input->name ?? '',
            order: $input->order,
            page: $input->page ?? 1,
            perPage: $input->perPage ?? 10,
        );

        return new ListCategoryOutputDTO(
            items: array_map(
                fn (CategoryEntity $category): array => [
                    'id' => $category->id(),
                    'name' => $category->name,
                    'description' => $category->description,
                    'isActive' => $category->isActive,
                    'createdAt' => $category->createdAt(),
                ],
                $categories->items()
            ),
            total: $categories->total(),
            currentPage: $categories->currentPage(),
            lastPage: $categories->lastPage(),
            perPage: $categories->perPage(),
        );
    }
}
