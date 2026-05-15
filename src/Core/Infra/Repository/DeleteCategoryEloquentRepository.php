<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository;

use App\Models\Category;

class DeleteCategoryEloquentRepository
{
    public function delete(string $id): bool
    {
        return Category::query()->findOrFail($id)->delete();
    }
}
