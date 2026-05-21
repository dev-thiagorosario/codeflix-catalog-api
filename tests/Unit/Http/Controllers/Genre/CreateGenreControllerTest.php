<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;
use App\Core\Application\Interfaces\Adapter\Genre\CreateGenreDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Genre\CreateGenreUsecaseInterface;
use App\Http\Controllers\Genre\CreateGenreController;
use App\Http\Requests\Genre\CreateGenreRequest;
use Mockery;
use Tests\TestCase;

class CreateGenreControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_creates_genre_using_adapter_and_usecase(): void
    {
        $categoryId = '37c6ee09-9538-4653-9965-a9b41b87fe1f';
        $validated = [
            'name' => 'Action',
            'is_active' => true,
            'categories_id' => [$categoryId],
        ];

        $input = new CreateGenreInputDTO(
            name: 'Action',
            isActive: true,
            categoriesId: [$categoryId],
        );

        $output = new CreateGenreOutputDTO(
            id: 'genre-id',
            name: 'Action',
            isActive: true,
            createdAt: '2026-05-21 10:00:00',
        );

        $responseData = [
            'id' => 'genre-id',
            'name' => 'Action',
            'is_active' => true,
            'created_at' => '2026-05-21 10:00:00',
        ];

        $request = Mockery::mock(CreateGenreRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(CreateGenreDataAdapterInterface::class);
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

        $usecase = Mockery::mock(CreateGenreUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new CreateGenreController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
