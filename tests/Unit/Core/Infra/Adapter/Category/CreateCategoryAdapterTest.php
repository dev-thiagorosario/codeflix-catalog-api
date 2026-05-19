<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\CreateCategoryInputDTO;
use App\Core\Application\DTO\Category\CreateCategoryOutputDTO;
use App\Core\Infra\Adapter\Category\CreateCategoryDataAdapter;
use PHPUnit\Framework\TestCase;

class CreateCategoryAdapterTest extends TestCase
{
    public function test_it_creates_input_dto_from_request_data(): void
    {
        $adapter = new CreateCategoryDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => '0',
        ]);

        $this->assertInstanceOf(CreateCategoryInputDTO::class, $input);
        $this->assertSame('Movies', $input->name);
        $this->assertSame('Movie category', $input->description);
        $this->assertFalse($input->isActive);
    }

    public function test_it_uses_defaults_when_optional_request_data_is_missing(): void
    {
        $adapter = new CreateCategoryDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Movies',
        ]);

        $this->assertSame('', $input->description);
        $this->assertTrue($input->isActive);
    }

    public function test_it_converts_output_dto_to_response_array(): void
    {
        $adapter = new CreateCategoryDataAdapter;

        $response = $adapter->toArray(new CreateCategoryOutputDTO(
            id: 'category-id',
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
            createdAt: '2026-05-18 10:00:00',
        ));

        $this->assertSame([
            'id' => 'category-id',
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
            'created_at' => '2026-05-18 10:00:00',
        ], $response);
    }
}
