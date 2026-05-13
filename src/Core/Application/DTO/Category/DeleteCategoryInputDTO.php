<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Category;

class DeleteCategoryInputDTO
{
    public function __construct(
        public string $id,
    ) {}
}
