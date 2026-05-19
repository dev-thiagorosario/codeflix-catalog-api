<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;
use App\Core\Infra\Adapter\Category\UpdateCategoryDataAdapter;
use PHPUnit\Framework\TestCase;

class UpdateCategoryAdapterTest extends TestCase
{
    public function test_it_creates_input_dto_from_request_data(): void
    {
        $adapter = new UpdateCategoryDataAdapter;

        $input = $adapter->fromArray([
            'id' => 'category-id',
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => '0',
        ]);

        $this->assertInstanceOf(UpdateCategoryInputDTO::class, $input);
        $this->assertSame('category-id', $input->id);
        $this->assertSame('Movies', $input->name);
        $this->assertSame('Movie category', $input->description);
        $this->assertFalse($input->isActive);
    }

    public function test_it_uses_defaults_when_optional_request_data_is_missing(): void
    {
        $adapter = new UpdateCategoryDataAdapter;

        $input = $adapter->fromArray([
            'id' => 'category-id',
            'name' => 'Movies',
        ]);

        $this->assertSame('', $input->description);
        $this->assertNull($input->isActive);
    }

    public function test_it_converts_output_dto_to_response_array(): void
    {
        $adapter = new UpdateCategoryDataAdapter;

        $response = $adapter->toArray(new UpdateCategoryOutputDTO(
            id: 'category-id',
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
            updatedAt: '2026-05-18 10:00:00',
        ));

        $this->assertSame([
            'id' => 'category-id',
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
            'updated_at' => '2026-05-18 10:00:00',
        ], $response);
    }
}
