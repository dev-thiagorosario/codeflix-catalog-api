<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Models\Genre;

class UpdateGenreEloquentRepository
{
    public function update(GenreEntity $genre): GenreEntity
    {
        $model = Genre::query()->findOrFail($genre->id());

        $model->update([
            'name' => $genre->name,
            'is_active' => $genre->isActive,
        ]);

        $model->categories()->sync($genre->categoriesId);

        return GenreEntity::fromModel($model->refresh()->load('categories'));
    }
}
