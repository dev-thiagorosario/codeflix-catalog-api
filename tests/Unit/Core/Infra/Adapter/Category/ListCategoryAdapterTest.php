<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\ListCategoryInputDTO;
use App\Core\Application\DTO\Category\ListCategoryOutputDTO;
use App\Core\Infra\Adapter\Category\ListCategoryDataAdapter;
use PHPUnit\Framework\TestCase;

class ListCategoryAdapterTest extends TestCase
{
    public function test_it_creates_input_dto_from_request_data(): void
    {
        $adapter = new ListCategoryDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Movies',
            'page' => '2',
            'per_page' => '10',
            'order' => 'ASC',
        ]);

        $this->assertInstanceOf(ListCategoryInputDTO::class, $input);
        $this->assertSame('Movies', $input->name);
        $this->assertSame(2, $input->page);
        $this->assertSame(10, $input->perPage);
        $this->assertSame('ASC', $input->order);
    }

    public function test_it_uses_defaults_when_optional_request_data_is_missing(): void
    {
        $adapter = new ListCategoryDataAdapter;

        $input = $adapter->fromArray([]);

        $this->assertNull($input->name);
        $this->assertNull($input->page);
        $this->assertNull($input->perPage);
        $this->assertSame('DESC', $input->order);
    }

    public function test_it_converts_output_dto_to_response_array(): void
    {
        $adapter = new ListCategoryDataAdapter;

        $response = $adapter->toArray(new ListCategoryOutputDTO(
            items: [
                [
                    'id' => 'category-id',
                    'name' => 'Movies',
                    'description' => 'Movie category',
                    'isActive' => true,
                    'createdAt' => '2026-05-18 10:00:00',
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
                    'id' => 'category-id',
                    'name' => 'Movies',
                    'description' => 'Movie category',
                    'is_active' => true,
                    'created_at' => '2026-05-18 10:00:00',
                ],
            ],
            'meta' => [
                'total' => 1,
                'current_page' => 2,
                'last_page' => 3,
                'per_page' => 10,
            ],
        ], $response);
    }
}
