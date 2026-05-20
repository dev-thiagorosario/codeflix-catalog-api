<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Genre;

/**
 * @param  array<int, array{id: string, name: string, isActive: bool, createdAt: string}>  $items
 */
class ListGenreOutputDTO
{
    public function __construct(
        public array $items = [],
        public int $total = 0,
        public int $currentPage = 1,
        public int $lastPage = 15,
        public int $perPage = 10,
    ) {}
}
