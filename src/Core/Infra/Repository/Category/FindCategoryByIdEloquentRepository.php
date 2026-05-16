<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Models\Category;

class FindCategoryByIdEloquentRepository
{
    public function findById(string $id): ?CategoryEntity
    {
        $model = Category::query()->find($id);

        if ($model === null) {
            return null;
        }

        return CategoryEntity::fromModel($model);
    }
}
