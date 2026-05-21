<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Genre;

use App\Core\Application\DTO\Genre\DeleteGenreInputDTO;
use App\Core\Application\Interfaces\Usecase\Genre\DeleteGenreUsecaseInterface;
use App\Core\Exception\GenreNotFoundException;
use App\Http\Controllers\Genre\DeleteGenreController;
use App\Http\Requests\Genre\DeleteGenreRequest;
use Mockery;
use Tests\TestCase;

class DeleteGenreControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_deletes_genre_using_usecase(): void
    {
        $validated = [
            'id' => 'genre-id',
        ];

        $request = Mockery::mock(DeleteGenreRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $usecase = Mockery::mock(DeleteGenreUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with(Mockery::on(fn (DeleteGenreInputDTO $input): bool => $input->id === 'genre-id'))
            ->andReturnNull();

        $controller = new DeleteGenreController($usecase);

        $response = $controller($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'status' => 'success',
            'data' => [],
        ], $response->getData(true));
    }

    public function test_it_returns_not_found_when_genre_does_not_exist(): void
    {
        $validated = [
            'id' => 'genre-id',
        ];

        $exception = new GenreNotFoundException;

        $request = Mockery::mock(DeleteGenreRequest::class);
        $request
            ->shouldReceive('validated')
            ->once()
            ->andReturn($validated);

        $usecase = Mockery::mock(DeleteGenreUsecaseInterface::class);
        $usecase
            ->shouldReceive('__invoke')
            ->once()
            ->with(Mockery::on(fn (DeleteGenreInputDTO $input): bool => $input->id === 'genre-id'))
            ->andThrow($exception);

        $controller = new DeleteGenreController($usecase);

        $response = $controller($request);

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame([
            'status' => 'error',
            'data' => [],
            'message' => 'Gênero Não Encontrado',
            'code' => 1010,
        ], $response->getData(true));
    }
}
