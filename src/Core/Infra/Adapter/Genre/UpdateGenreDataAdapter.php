<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;
use App\Core\Application\Interfaces\Adapter\Genre\UpdateGenreDataAdapterInterface;

class UpdateGenreDataAdapter implements UpdateGenreDataAdapterInterface
{
    /**
     * @param  array{id: string, name: string, is_active?: bool|int|string|null, categories_id_to_add?: array<int, string>|null, categories_id_to_remove?: array<int, string>|null}  $data
     */
    public function fromArray(array $data): UpdateGenreInputDTO
    {
        return new UpdateGenreInputDTO(
            id: $data['id'],
            name: $data['name'],
            categoriesIdsToAdd: $data['categories_id_to_add'] ?? null,
            isActive: array_key_exists('is_active', $data)
                ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN)
                : null,
            categoriesIdsToRemove: $data['categories_id_to_remove'] ?? null,
        );
    }

    /**
     * @return array{id: string, name: string, is_active: bool, updated_at: string}
     */
    public function toArray(UpdateGenreOutputDTO $genre): array
    {
        return [
            'id' => $genre->id,
            'name' => $genre->name,
            'is_active' => $genre->isActive,
            'updated_at' => $genre->updatedAt,
        ];
    }
}
