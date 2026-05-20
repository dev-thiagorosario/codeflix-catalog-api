<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\ListGenreInputDTO;
use App\Core\Application\DTO\Genre\ListGenreOutputDTO;

interface ListGenreUsecaseInterface
{
    public function __invoke(ListGenreInputDTO $input): ListGenreOutputDTO;
}
