<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Models\Category;

class FindAllCategoriesEloquentRepository
{
    /**
     * @return CategoryEntity[]
     */
    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $categories = Category::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->get();

        return $categories
            ->map(fn (Category $category) => CategoryEntity::fromModel($category))
            ->toArray();

    }
}
