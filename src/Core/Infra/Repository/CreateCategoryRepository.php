<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Models\Category;

abstract class CreateCategoryRepository implements CategoryRepositoryInterface
{
    public function insert(CategoryEntity $category): CategoryEntity
    {
        $model = Category::query()->create([
            'id' => $category->id(),
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
        ]);

        return CategoryEntity::fromModel($model);
    }
}
