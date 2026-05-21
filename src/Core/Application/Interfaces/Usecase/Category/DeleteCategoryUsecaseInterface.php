<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Usecase\Category;

use App\Core\Application\DTO\Category\DeleteCategoryInputDTO;

interface DeleteCategoryUsecaseInterface
{
    public function __invoke(DeleteCategoryInputDTO $input): void;
}
