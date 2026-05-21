<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;
use App\Core\Infra\Adapter\Genre\CreateGenreDataAdapter;
use PHPUnit\Framework\TestCase;

class CreateGenreDataAdapterTest extends TestCase
{
    public function test_it_converts_array_to_input_dto(): void
    {
        $categoryId = '37c6ee09-9538-4653-9965-a9b41b87fe1f';
        $adapter = new CreateGenreDataAdapter;

        $input = $adapter->fromArray([
            'name' => 'Action',
            'is_active' => 'false',
            'categories_id' => [$categoryId],
        ]);

        $this->assertInstanceOf(CreateGenreInputDTO::class, $input);
        $this->assertSame('Action', $input->name);
        $this->assertFalse($input->isActive);
        $this->assertSame([$categoryId], $input->categoriesId);
    }

    public function test_it_converts_output_dto_to_array(): void
    {
        $adapter = new CreateGenreDataAdapter;

        $result = $adapter->toArray(new CreateGenreOutputDTO(
            id: 'genre-id',
            name: 'Action',
            isActive: true,
            createdAt: '2026-05-21 10:00:00',
        ));

        $this->assertSame([
            'id' => 'genre-id',
            'name' => 'Action',
            'is_active' => true,
            'created_at' => '2026-05-21 10:00:00',
        ], $result);
    }
}
