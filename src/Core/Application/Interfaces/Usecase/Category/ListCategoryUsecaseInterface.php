<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\Category;

use App\Core\Application\DTO\Category\ListCategoryInputDTO;
use App\Core\Application\DTO\Category\ListCategoryOutputDTO;

interface ListCategoryUsecaseInterface
{
    public function __invoke(ListCategoryInputDTO $input): ListCategoryOutputDTO;
}
