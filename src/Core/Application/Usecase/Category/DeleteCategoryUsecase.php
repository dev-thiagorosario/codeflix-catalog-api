<?php

declare(strict_types=1);

namespace App\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\DeleteCategoryInputDTO;
use App\Core\Application\Interfaces\Category\DeleteCategoryUsecaseInterface;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Exception\CategoryNotFoundException;

class DeleteCategoryUsecase implements DeleteCategoryUsecaseInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteCategoryInputDTO $input): void
    {
        $category = $this->repository->findById($input->id);

        if ($category === null) {
            throw new CategoryNotFoundException;
        }

        $this->repository->delete($input->id);
    }
}
