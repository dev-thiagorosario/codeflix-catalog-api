<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;

interface UpdateGenreUsecaseInterface
{
    public function __invoke(UpdateGenreInputDTO $input): UpdateGenreOutputDTO;
}
