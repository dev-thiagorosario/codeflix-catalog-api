<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Models\Category;

class UpdateCategoryEloquentRepository
{
    public function update(CategoryEntity $category): CategoryEntity
    {
        $model = Category::query()->findOrFail($category->id());

        $model->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
        ]);

        return CategoryEntity::fromModel($model->refresh());
    }
}
