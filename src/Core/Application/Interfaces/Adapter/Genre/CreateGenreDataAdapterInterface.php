<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Adapter\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;

interface CreateGenreDataAdapterInterface
{
    /**
     * @param  array{name: string, is_active?: bool|int|string, categories_id?: array<int, string>}  $data
     */
    public function fromArray(array $data): CreateGenreInputDTO;

    /**
     * @return array{id: string, name: string, is_active: bool, created_at: string}
     */
    public function toArray(CreateGenreOutputDTO $genre): array;
}
