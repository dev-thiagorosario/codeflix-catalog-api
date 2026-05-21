<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;
use App\Core\Application\Interfaces\Adapter\Genre\CreateGenreDataAdapterInterface;

class CreateGenreDataAdapter implements CreateGenreDataAdapterInterface
{
    /**
     * @param  array{name: string, is_active?: bool|int|string, categories_id?: array<int, string>}  $data
     */
    public function fromArray(array $data): CreateGenreInputDTO
    {
        return new CreateGenreInputDTO(
            name: $data['name'],
            isActive: array_key_exists('is_active', $data)
                ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN)
                : true,
            categoriesId: $data['categories_id'] ?? [],
        );
    }

    /**
     * @return array{id: string, name: string, is_active: bool, created_at: string}
     */
    public function toArray(CreateGenreOutputDTO $genre): array
    {
        return [
            'id' => $genre->id,
            'name' => $genre->name,
            'is_active' => $genre->isActive,
            'created_at' => $genre->createdAt,
        ];
    }
}
