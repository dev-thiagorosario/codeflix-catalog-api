<?php

declare(strict_types=1);

namespace App\Core\Infra\Repository\Category;

use App\Models\Category;

class GetIdsByCategoryIdsEloquentRepository
{
    /**
     * @param  array<int, string>  $categoryIds
     * @return array<int, string>
     */
    public function getIdsByCategoryIds(array $categoryIds = []): array
    {
        if ($categoryIds === []) {
            return [];
        }

        $foundCategoryIds = Category::query()
            ->whereIn('id', $categoryIds)
            ->pluck('id')
            ->all();

        return $foundCategoryIds;
    }
}
