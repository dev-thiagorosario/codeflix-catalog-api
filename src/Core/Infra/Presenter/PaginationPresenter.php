<?php

declare(strict_types=1);

namespace App\Core\Infra\Presenter;

use App\Core\Domain\Repository\PaginationInterface;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @template TModel of object
 * @template TItem
 */
final readonly class PaginationPresenter implements PaginationInterface
{
    /**
     * @param  LengthAwarePaginator<int, TModel>  $paginator
     * @param  Closure(TModel): TItem  $mapper
     */
    public function __construct(
        private LengthAwarePaginator $paginator,
        private Closure $mapper,
    ) {}

    /**
     * @return array<int, TItem>
     */
    public function items(): array
    {
        return array_map($this->mapper, $this->paginator->items());
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
