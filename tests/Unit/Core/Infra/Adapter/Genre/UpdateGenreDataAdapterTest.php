<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Adapter\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;
use App\Core\Infra\Adapter\Genre\UpdateGenreDataAdapter;
use PHPUnit\Framework\TestCase;

class UpdateGenreDataAdapterTest extends TestCase
{
    public function test_it_converts_array_to_input_dto(): void
    {
        $categoryId = '37c6ee09-9538-4653-9965-a9b41b87fe1f';
        $adapter = new UpdateGenreDataAdapter;

        $input = $adapter->fromArray([
            'id' => 'genre-id',
            'name' => 'Action',
            'is_active' => 'false',
            'categories_id_to_add' => [$categoryId],
            'categories_id_to_remove' => [],
        ]);

        $this->assertInstanceOf(UpdateGenreInputDTO::class, $input);
        $this->assertSame('genre-id', $input->id);
        $this->assertSame('Action', $input->name);
        $this->assertFalse($input->isActive);
        $this->assertSame([$categoryId], $input->categoriesIdsToAdd);
        $this->assertSame([], $input->categoriesIdsToRemove);
    }

    public function test_it_converts_output_dto_to_array(): void
    {
        $adapter = new UpdateGenreDataAdapter;

        $result = $adapter->toArray(new UpdateGenreOutputDTO(
            id: 'genre-id',
            name: 'Action',
            isActive: true,
            updatedAt: '2026-05-21 10:00:00',
        ));

        $this->assertSame([
            'id' => 'genre-id',
            'name' => 'Action',
            'is_active' => true,
            'updated_at' => '2026-05-21 10:00:00',
        ], $result);
    }
}
