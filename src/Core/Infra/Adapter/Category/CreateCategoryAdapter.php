<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\CreateCategoryInputDTO;
use App\Core\Application\DTO\Category\CreateCategoryOutputDTO;

class CreateCategoryAdapter implements CreateCategoryAdapterInterface
{
    /**
     * @param  array{name: string, description?: string|null, is_active?: bool|int|string}  $data
     */
    public function fromArray(array $data): CreateCategoryInputDTO
    {
        return new CreateCategoryInputDTO(
            name: $data['name'],
            description: $data['description'] ?? '',
            isActive: array_key_exists('is_active', $data)
                ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN)
                : true,
        );
    }

    /**
     * @return array{id: string, name: string, description: string, is_active: bool, created_at: string}
     */
    public function toArray(CreateCategoryOutputDTO $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
            'created_at' => $category->createdAt,
        ];
    }
}
