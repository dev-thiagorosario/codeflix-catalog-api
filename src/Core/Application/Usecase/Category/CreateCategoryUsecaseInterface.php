<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\CreateCategoryDTO;
use App\Core\Domain\Entity\CategoryEntity;

interface CreateCategoryUsecaseInterface
{
    public function __invoke(CreateCategoryDTO $input): CategoryEntity;
}
