<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Category;

class CreateCategoryInputDTO
{
    public function __construct(
        public string $name,
        public string $description = '',
        public bool $isActive = true,
    ){}
}
