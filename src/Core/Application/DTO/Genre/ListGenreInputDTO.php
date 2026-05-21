<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Genre;

class ListGenreInputDTO
{
    public function __construct(
        public string $id
    ) {}
}
