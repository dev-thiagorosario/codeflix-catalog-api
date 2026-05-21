<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\Genre;

use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;

interface ListGenresUsecaseInterface
{
    public function __invoke(ListGenresInputDTO $input): ListGenresOutputDTO;
}
