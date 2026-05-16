<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository\Category;

use App\Models\Category;

class DeleteCategoryEloquentRepository
{
    public function delete(string $id): bool
    {
        return Category::query()->findOrFail($id)->delete();
    }
}
