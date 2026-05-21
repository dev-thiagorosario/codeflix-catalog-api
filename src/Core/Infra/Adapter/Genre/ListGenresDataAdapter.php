<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Genre;

use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;
use App\Core\Application\Interfaces\Adapter\Genre\ListGenresDataAdapterInterface;

class ListGenresDataAdapter implements ListGenresDataAdapterInterface
{
    /**
     * @param  array{name?: string|null, page?: int|string|null, per_page?: int|string|null, order?: string|null}  $data
     */
    public function fromArray(array $data): ListGenresInputDTO
    {
        return new ListGenresInputDTO(
            name: $data['name'] ?? null,
            page: isset($data['page']) ? (int) $data['page'] : null,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : null,
            order: $data['order'] ?? 'DESC',
        );
    }

    /**
     * @return array{items: array<int, array{id: string, name: string, is_active: bool, created_at: string}>, meta: array{total: int, current_page: int, last_page: int, per_page: int}}
     */
    public function toArray(ListGenresOutputDTO $genres): array
    {
        return [
            'items' => array_map(
                fn (array $genre): array => [
                    'id' => $genre['id'],
                    'name' => $genre['name'],
                    'is_active' => $genre['isActive'],
                    'created_at' => $genre['createdAt'],
                ],
                $genres->items,
            ),
            'meta' => [
                'total' => $genres->total,
                'current_page' => $genres->currentPage,
                'last_page' => $genres->lastPage,
                'per_page' => $genres->perPage,
            ],
        ];
    }
}
