<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;
use App\Core\Application\Interfaces\Adapter\CastMember\ListCastMembersDataAdapterInterface;

class ListCastMembersDataAdapter implements ListCastMembersDataAdapterInterface
{
    /**
     * @param  array{name?: string|null, page?: int|string|null, per_page?: int|string|null, order?: string|null}  $data
     */
    public function fromArray(array $data): ListCastMembersInputDTO
    {
        return new ListCastMembersInputDTO(
            name: $data['name'] ?? null,
            page: isset($data['page']) ? (int) $data['page'] : null,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : null,
            order: $data['order'] ?? 'DESC',
        );
    }

    /**
     * @return array{items: array<int, array{id: string, name: string, type: int, created_at: string}>, meta: array{total: int, current_page: int, last_page: int, per_page: int}}
     */
    public function toArray(ListCastMembersOutputDTO $castMembers): array
    {
        return [
            'items' => array_map(
                fn (array $castMember): array => [
                    'id' => $castMember['id'],
                    'name' => $castMember['name'],
                    'type' => $castMember['type'],
                    'created_at' => $castMember['createdAt'],
                ],
                $castMembers->items,
            ),
            'meta' => [
                'total' => $castMembers->total,
                'current_page' => $castMembers->currentPage,
                'last_page' => $castMembers->lastPage,
                'per_page' => $castMembers->perPage,
            ],
        ];
    }
}
