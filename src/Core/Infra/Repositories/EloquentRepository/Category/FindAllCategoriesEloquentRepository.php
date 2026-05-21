<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Repositories\Paginate\CategoryPagination;
use App\Models\Category;

class FindAllCategoriesEloquentRepository
{
    /**
     * @return CategoryEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $categories = Category::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->get();

        return $categories
            ->map(fn (Category $category) => CategoryEntity::fromModel($category))
            ->all();
    }

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface
    {
        $categories = Category::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->paginate(perPage: $perPage, page: $page);

        return new CategoryPagination($categories);
    }
}
