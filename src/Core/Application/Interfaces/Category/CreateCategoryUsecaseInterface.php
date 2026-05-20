<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Category;

use App\Core\Application\DTO\Category\CreateCategoryInputDTO;
use App\Core\Application\DTO\Category\CreateCategoryOutputDTO;

interface CreateCategoryUsecaseInterface
{
    public function __invoke(CreateCategoryInputDTO $input): CreateCategoryOutputDTO;
}
