<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\DeleteGenreInputDTO;

interface DeleteGenreUsecaseInterface
{
    public function __invoke(DeleteGenreInputDTO $input): void;
}
