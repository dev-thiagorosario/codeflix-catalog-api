<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\ListCategoryInputDTO;
use App\Core\Application\DTO\Category\ListCategoryOutputDTO;

class ListCategoryDataAdapter implements ListCategoryDataAdapterInterface
{
    /**
     * @param  array{name?: string|null, page?: int|string|null, per_page?: int|string|null, order?: string|null}  $data
     */
    public function fromArray(array $data): ListCategoryInputDTO
    {
        return new ListCategoryInputDTO(
            name: $data['name'] ?? null,
            page: isset($data['page']) ? (int) $data['page'] : null,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : null,
            order: $data['order'] ?? 'DESC',
        );
    }

    /**
     * @return array{items: array<int, array{id: string, name: string, description: string, is_active: bool, created_at: string}>, meta: array{total: int, current_page: int, last_page: int, per_page: int}}
     */
    public function toArray(ListCategoryOutputDTO $categories): array
    {
        return [
            'items' => array_map(
                fn (array $category): array => [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'is_active' => $category['isActive'],
                    'created_at' => $category['createdAt'],
                ],
                $categories->items,
            ),
            'meta' => [
                'total' => $categories->total,
                'current_page' => $categories->currentPage,
                'last_page' => $categories->lastPage,
                'per_page' => $categories->perPage,
            ],
        ];
    }
}
