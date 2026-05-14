<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Models\Category;

abstract class FindCategoryByIdEloquentRepository implements CategoryRepositoryInterface
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
