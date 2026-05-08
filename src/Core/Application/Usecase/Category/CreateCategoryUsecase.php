<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\CreateCategoryDTO;
use App\Core\Domain\Entity\CategoryEntity;

class CreateCategoryUsecase implements CreateCategoryUsecaseInterface
{
    public function __construct(

    ){}

    public function __invoke(CreateCategoryDTO $dto): CategoryEntity
    {
        // TODO: Implement __invoke() method.
    }
}
