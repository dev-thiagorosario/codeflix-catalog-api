<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Genre;

class DeleteGenreInputDTO
{
    public function __construct(
        public string $id,
    ) {}
}
