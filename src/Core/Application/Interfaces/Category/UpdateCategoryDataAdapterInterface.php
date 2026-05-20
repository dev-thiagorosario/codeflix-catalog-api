<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;

interface UpdateCategoryDataAdapterInterface
{
    /**
     * @param  array{id: string, name: string, description?: string|null, is_active?: bool|int|string|null}  $data
     */
    public function fromArray(array $data): UpdateCategoryInputDTO;

    /**
     * @return array{id: string, name: string, description: string, is_active: bool, updated_at: string}
     */
    public function toArray(UpdateCategoryOutputDTO $category): array;
}
