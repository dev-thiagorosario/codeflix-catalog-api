<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Models\Category;

class CreateCategoryEloquentRepository
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
