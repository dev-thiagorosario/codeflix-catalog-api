<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;
use App\Core\Application\Interfaces\Category\UpdateCategoryDataAdapterInterface;

class UpdateCategoryDataAdapter implements UpdateCategoryDataAdapterInterface
{
    /**
     * @param  array{id: string, name: string, description?: string|null, is_active?: bool|int|string|null}  $data
     */
    public function fromArray(array $data): UpdateCategoryInputDTO
    {
        return new UpdateCategoryInputDTO(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? '',
            isActive: array_key_exists('is_active', $data)
                ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN)
                : null,
        );
    }

    /**
     * @return array{id: string, name: string, description: string, is_active: bool, updated_at: string}
     */
    public function toArray(UpdateCategoryOutputDTO $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
            'updated_at' => $category->updatedAt,
        ];
    }
}
