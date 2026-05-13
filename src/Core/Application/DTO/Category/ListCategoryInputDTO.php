<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Category;

class ListCategoryInputDTO
{
    public function __construct(
        public ?string $name = null,
        public ?int $page = null,
        public ?int $perPage = null,
        public string $order = 'DESC',
    ) {}
}
