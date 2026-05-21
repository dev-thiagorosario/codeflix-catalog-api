<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Adapter\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;

interface UpdateGenreDataAdapterInterface
{
    /**
     * @param  array{id: string, name: string, is_active?: bool|int|string|null, categories_id_to_add?: array<int, string>|null, categories_id_to_remove?: array<int, string>|null}  $data
     */
    public function fromArray(array $data): UpdateGenreInputDTO;

    /**
     * @return array{id: string, name: string, is_active: bool, updated_at: string}
     */
    public function toArray(UpdateGenreOutputDTO $genre): array;
}
