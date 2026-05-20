<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Genre;

class UpdateGenreOutputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $isActive,
        public string $updatedAt,
    ) {}
}
