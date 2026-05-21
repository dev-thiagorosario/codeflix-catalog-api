<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Genre;

use App\Models\Genre;

class DeleteGenreEloquentRepository
{
    public function delete(string $id): bool
    {
        return Genre::query()->findOrFail($id)->delete();
    }
}
