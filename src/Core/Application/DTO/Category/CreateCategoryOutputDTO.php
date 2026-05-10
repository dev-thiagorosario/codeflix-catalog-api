<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Category;

class CreateCategoryOutputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public bool $isActive,
        public string $createdAt,
    ) {}
}
