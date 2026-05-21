<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;
use App\Core\Application\Interfaces\Adapter\Genre\UpdateGenreDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Genre\UpdateGenreUsecaseInterface;
use App\Http\Controllers\Genre\UpdateGenreController;
use App\Http\Requests\Genre\UpdateGenreRequest;
use Mockery;
use Tests\TestCase;

class UpdateGenreControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_updates_genre_using_adapter_and_usecase(): void
    {
        $categoryId = '37c6ee09-9538-4653-9965-a9b41b87fe1f';
        $validated = [
            'id' => 'genre-id',
            'name' => 'Action',
            'is_active' => true,
            'categories_id_to_add' => [$categoryId],
            'categories_id_to_remove' => [],
        ];

        $input = new UpdateGenreInputDTO(
            id: 'genre-id',
            name: 'Action',
            categoriesIdsToAdd: [$categoryId],
            isActive: true,
            categoriesIdsToRemove: [],
        );

        $output = new UpdateGenreOutputDTO(
            id: 'genre-id',
            name: 'Action',
            isActive: true,
            updatedAt: '2026-05-21 10:00:00',
        );

        $responseData = [
            'id' => 'genre-id',
            'name' => 'Action',
            'is_active' => true,
            'updated_at' => '2026-05-21 10:00:00',
        ];

        $request = Mockery::mock(UpdateGenreRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(UpdateGenreDataAdapterInterface::class);
        $adapter
            ->shouldReceive('fromArray')
            ->once()
            ->with($validated)
            ->andReturn($input);
        $adapter
            ->shouldReceive('toArray')
            ->once()
            ->with($output)
            ->andReturn($responseData);

        $usecase = Mockery::mock(UpdateGenreUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new UpdateGenreController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
