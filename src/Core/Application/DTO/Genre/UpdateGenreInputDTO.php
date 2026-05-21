<?php

declare(strict_types=1);

namespace App\Core\Application\DTO\Genre;

class UpdateGenreInputDTO
{
    /**
     * @param  array<int, string>|null  $categoriesIdsToAdd
     * @param  array<int, string>|null  $categoriesIdsToRemove
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?array $categoriesIdsToAdd = null,
        public ?bool $isActive = null,
        public ?array $categoriesIdsToRemove = null,
    ) {}
}
