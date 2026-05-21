<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Genre;

use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;
use App\Core\Application\Interfaces\Adapter\Genre\ListGenresDataAdapterInterface;
use App\Core\Application\Interfaces\Usecase\Genre\ListGenresUsecaseInterface;
use App\Http\Controllers\Genre\ListGenreController;
use App\Http\Requests\Genre\ListGenreRequest;
use Mockery;
use Tests\TestCase;

class ListGenreControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_lists_genres_using_adapter_and_usecase(): void
    {
        $validated = [
            'name' => 'Action',
            'page' => 2,
            'per_page' => 10,
            'order' => 'ASC',
        ];

        $input = new ListGenresInputDTO(
            name: 'Action',
            page: 2,
            perPage: 10,
            order: 'ASC',
        );

        $output = new ListGenresOutputDTO(
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
        );

        $responseData = [
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
        ];

        $request = Mockery::mock(ListGenreRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $adapter = Mockery::mock(ListGenresDataAdapterInterface::class);
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

        $usecase = Mockery::mock(ListGenresUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with($input)
            ->andReturn($output);

        $controller = new ListGenreController($usecase, $adapter);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => $responseData,
        ], $response->getData(true));
    }
}
