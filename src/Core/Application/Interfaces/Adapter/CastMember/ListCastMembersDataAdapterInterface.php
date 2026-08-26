<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Adapter\CastMember;

use App\Core\Application\DTO\CastMember\ListCastMembersInputDTO;
use App\Core\Application\DTO\CastMember\ListCastMembersOutputDTO;

interface ListCastMembersDataAdapterInterface
{
    /**
     * @param  array{name?: string|null, page?: int|string|null, per_page?: int|string|null, order?: string|null}  $data
     */
    public function fromArray(array $data): ListCastMembersInputDTO;

    /**
     * @return array{items: array<int, array{id: string, name: string, type: int, created_at: string}>, meta: array{total: int, current_page: int, last_page: int, per_page: int}}
     */
    public function toArray(ListCastMembersOutputDTO $castMembers): array;
}
