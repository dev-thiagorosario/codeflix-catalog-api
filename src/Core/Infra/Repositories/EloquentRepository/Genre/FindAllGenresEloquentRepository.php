<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\EloquentRepository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Presenter\PaginationPresenter;
use App\Models\Genre;

class FindAllGenresEloquentRepository
{
    /**
     * @return GenreEntity[]
     */
    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $genres = Genre::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->get();

        return $genres
            ->map(fn (Genre $genre): GenreEntity => GenreEntity::fromModel($genre))
            ->all();
    }

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $perPage = 10): PaginationInterface
    {
        $genres = Genre::query()
            ->when($filter, function ($query, string $filter) {
                $query->where('name', 'like', "%{$filter}%");
            })
            ->orderBy('name', $order)
            ->paginate(perPage: $perPage, page: $page);

        return new PaginationPresenter(
            $genres,
            fn (Genre $genre): GenreEntity => GenreEntity::fromModel($genre),
        );
    }
}
