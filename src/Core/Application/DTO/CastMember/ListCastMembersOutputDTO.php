<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\CastMember;

/**
 * @param  array<int, array{id: string, name: string, type: int, createdAt: string}>  $items
 */
class ListCastMembersOutputDTO
{
    public function __construct(
        public array $items = [],
        public int $total = 0,
        public int $currentPage = 1,
        public int $lastPage = 1,
        public int $perPage = 10,
    ) {}
}
