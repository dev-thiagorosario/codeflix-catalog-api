<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Domain\Repository\PaginationInterface;
use App\Models\Category;

final readonly class CategoryEloquentRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private CreateCategoryEloquentRepository $createCategoryRepository,
        private FindCategoryByIdEloquentRepository $findCategoryByIdRepository,
        private FindAllCategoriesEloquentRepository $findAllCategoriesRepository,
        private UpdateCategoryEloquentRepository $updateCategoryRepository,
        private DeleteCategoryEloquentRepository $deleteCategoryRepository,
    ) {}

    public function insert(CategoryEntity $category): CategoryEntity
    {
        return $this->createCategoryRepository->insert($category);
    }

    public function findById(string $id): ?CategoryEntity
    {
        return $this->findCategoryByIdRepository->findById($id);
    }

    /**
     * @return CategoryEntity[]
     */
    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        return $this->findAllCategoriesRepository->findAll($filter, $order);
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface
    {
        return $this->findAllCategoriesRepository->paginate($filter, $order, $page, $perPage);
    }

    public function update(CategoryEntity $category): CategoryEntity
    {
        return $this->updateCategoryRepository->update($category);
    }

    public function delete(string $id): bool
    {
        return $this->deleteCategoryRepository->delete($id);
    }

    public function toCategoryEntity(object $data): ?CategoryEntity
    {
        if (! $data instanceof Category) {
            return null;
        }

        return CategoryEntity::fromModel($data);
    }
}
