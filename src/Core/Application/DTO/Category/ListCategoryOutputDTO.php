<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Category;

/**
 * @param  array<int, array{id: string, name: string, description: string, isActive: bool, createdAt: string}>  $items
 */
class ListCategoryOutputDTO
{
    public function __construct(
        public array $items = [],
        public int $total = 0,
        public int $currentPage = 1,
        public int $lastPage = 1,
        public int $perPage = 10,
    ) {}
}
