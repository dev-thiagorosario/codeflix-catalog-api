<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;

interface CreateGenreUsecaseInterface
{
    public function __invoke(CreateGenreInputDTO $input): CreateGenreOutputDTO;
}
