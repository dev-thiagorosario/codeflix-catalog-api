<?php

declare(strict_types=1);

namespace App\Core\Application\Interfaces\Adapter\Genre;

use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;

interface ListGenresDataAdapterInterface
{
    /**
     * @param  array{name?: string|null, page?: int|string|null, per_page?: int|string|null, order?: string|null}  $data
     */
    public function fromArray(array $data): ListGenresInputDTO;

    /**
     * @return array{items: array<int, array{id: string, name: string, is_active: bool, created_at: string}>, meta: array{total: int, current_page: int, last_page: int, per_page: int}}
     */
    public function toArray(ListGenresOutputDTO $genres): array;
}
