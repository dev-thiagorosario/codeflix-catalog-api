<?php

declare(strict_types=1);

namespace App\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\CreateCategoryInputDTO;
use App\Core\Application\DTO\Category\CreateCategoryOutputDTO;

interface CreateCategoryDataAdapterInterface
{
    /**
     * @param  array{name: string, description?: string|null, is_active?: bool|int|string}  $data
     */
    public function fromArray(array $data): CreateCategoryInputDTO;

    /**
     * @return array{id: string, name: string, description: string, is_active: bool, created_at: string}
     */
    public function toArray(CreateCategoryOutputDTO $category): array;
}
