<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Models\Genre;

class CreateGenreEloquentRepository
{
    public function insert(GenreEntity $genre): GenreEntity
    {
        $model = Genre::query()->create([
            'id' => $genre->id(),
            'name' => $genre->name,
            'is_active' => $genre->isActive,
        ]);

        return GenreEntity::fromModel($model);
    }
}
