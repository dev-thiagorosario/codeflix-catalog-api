<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\Genre;

use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;
use App\Core\Infra\Adapter\Genre\ListGenresDataAdapter;
use PHPUnit\Framework\TestCase;

class ListGenresDataAdapterTest extends TestCase
{
    public function test_it_converts_array_to_input_dto(): void
    {
        $adapter = new ListGenresDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Action',
            'page' => '2',
            'per_page' => '10',
            'order' => 'ASC',
        ]);

        $this->assertInstanceOf(ListGenresInputDTO::class, $input);
        $this->assertSame('Action', $input->name);
        $this->assertSame(2, $input->page);
        $this->assertSame(10, $input->perPage);
        $this->assertSame('ASC', $input->order);
    }

    public function test_it_converts_output_dto_to_array(): void
    {
        $adapter = new ListGenresDataAdapter;

        $result = $adapter->toArray(new ListGenresOutputDTO(
            items: [
                [
                    'id' => 'genre-id',
                    'name' => 'Action',
                    'isActive' => true,
                    'createdAt' => '2026-05-21 10:00:00',
                ],
            ],
            total: 1,
            currentPage: 2,
            lastPage: 3,
            perPage: 10,
        ));

        $this->assertSame([
            'items' => [
                [
                    'id' => 'genre-id',
                    'name' => 'Action',
                    'is_active' => true,
                    'created_at' => '2026-05-21 10:00:00',
                ],
            ],
            'meta' => [
                'total' => 1,
                'current_page' => 2,
                'last_page' => 3,
                'per_page' => 10,
            ],
        ], $result);
    }
}
