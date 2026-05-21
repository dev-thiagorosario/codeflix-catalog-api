<?php

declare(strict_types=1);

namespace App\Core\Infra\Repositories\Paginate;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class CategoryPagination implements PaginationInterface
{
    public function __construct(
        private LengthAwarePaginator $paginator,
    ) {}

    /**
     * @return CategoryEntity[]
     */
    public function items(): array
    {
        return array_map(
            fn (Category $category): CategoryEntity => CategoryEntity::fromModel($category),
            $this->paginator->items(),
        );
    }

    public function total(): int
    {
        return $this->paginator->total();
    }

    public function lastPage(): int
    {
        return $this->paginator->lastPage();
    }

    public function currentPage(): int
    {
        return $this->paginator->currentPage();
    }

    public function firstPage(): int
    {
        return 1;
    }

    public function perPage(): int
    {
        return $this->paginator->perPage();
    }

    public function to(): int
    {
        return $this->paginator->lastItem() ?? 0;
    }

    public function from(): int
    {
        return $this->paginator->firstItem() ?? 0;
    }
}
