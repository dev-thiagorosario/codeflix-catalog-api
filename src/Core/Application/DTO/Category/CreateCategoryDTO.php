<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Category;

class CreateCategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public bool $isActive = true,
    ){}
}
