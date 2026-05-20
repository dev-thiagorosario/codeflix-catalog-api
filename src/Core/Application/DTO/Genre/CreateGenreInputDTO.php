<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Genre;

class CreateGenreInputDTO
{
    public function __construct(
        public string $name,
        public bool $isActive = true,
    ) {}
}
