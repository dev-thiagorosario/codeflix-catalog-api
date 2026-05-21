<?php

declare(strict_types=1);

namespace App\Core\Application\Service;

use App\Core\Application\Interfaces\Service\ValidateCategoryIdServiceInterface;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Exception\CategoryNotFoundException;

class ValidateCategoryIdService implements ValidateCategoryIdServiceInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {}

    public function validate(array $categoriesId): void
    {
        $categoriesId = array_values(array_unique($categoriesId));

        if ($categoriesId === []) {
            return;
        }

        $categories = $this->repository->getIdsByCategoryIds($categoriesId);

        $notFoundCategories = [];

        foreach ($categoriesId as $categoryId) {
            if (! in_array($categoryId, $categories, true)) {
                $notFoundCategories[] = $categoryId;
            }
        }

        if (count($notFoundCategories)) {
            $msg = sprintf(
                '%s %s not found',
                count($notFoundCategories) > 1 ? 'Categories' : 'Category',
                implode(', ', $notFoundCategories)
            );

            throw new CategoryNotFoundException($msg);
        }
    }
}
