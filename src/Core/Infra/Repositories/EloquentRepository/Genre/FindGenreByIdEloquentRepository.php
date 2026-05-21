<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Models\Genre;

class FindGenreByIdEloquentRepository
{
    public function findById(string $id): ?GenreEntity
    {
        $model = Genre::query()
            ->with('categories')
            ->find($id);

        if ($model === null) {
            return null;
        }

        return GenreEntity::fromModel($model);
    }
}
