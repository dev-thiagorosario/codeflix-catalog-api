<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;

interface UpdateCategoryUsecaseInterface
{
    public function __invoke(UpdateCategoryInputDTO $input): UpdateCategoryOutputDTO;
}
