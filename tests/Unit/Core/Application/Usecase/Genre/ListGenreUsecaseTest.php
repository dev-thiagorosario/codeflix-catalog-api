<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\ListGenreInputDTO;
use App\Core\Application\DTO\Genre\ListGenreOutputDTO;
use App\Core\Application\DTO\Genre\ListGenresInputDTO;
use App\Core\Application\DTO\Genre\ListGenresOutputDTO;
use App\Core\Application\Usecase\Genre\ListGenresUsecase;
use App\Core\Application\Usecase\Genre\ListGenreUsecase;
use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\GenreNotFoundException;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListGenreUsecaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_list_genre_by_id(): void
    {
        $genreId = UuidResolver::random();
        $genre = new GenreEntity(
            id: $genreId,
            name: 'Action',
            isActive: true,
            createdAt: new DateTime('2026-05-19 10:00:00'),
        );

        $input = new ListGenreInputDTO(
            id: (string) $genreId,
        );

        $genreRepository = Mockery::mock(GenreRepositoryInterface::class);
        $genreRepository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $genreId)
            ->andReturn($genre);

        $usecase = new ListGenreUsecase($genreRepository);

        $result = $usecase($input);

        $this->assertInstanceOf(ListGenreOutputDTO::class, $result);
        $this->assertSame((string) $genreId, $result->id);
        $this->assertSame('Action', $result->name);
        $this->assertTrue($result->isActive);
        $this->assertSame('2026-05-19 10:00:00', $result->createdAt);
    }

    public function test_list_genre_by_id_throws_exception_when_genre_does_not_exist(): void
    {
        $genreId = (string) UuidResolver::random();
        $input = new ListGenreInputDTO(
            id: $genreId,
        );

        $genreRepository = Mockery::mock(GenreRepositoryInterface::class);
        $genreRepository
            ->shouldReceive('findById')
            ->once()
            ->with($genreId)
            ->andReturnNull();

        $usecase = new ListGenreUsecase($genreRepository);

        $this->expectException(GenreNotFoundException::class);
        $this->expectExceptionMessage('Gênero Não Encontrado');

        $usecase($input);
    }

    public function test_list_genres(): void
    {
        $genreId = UuidResolver::random();
        $genre = new GenreEntity(
            id: $genreId,
            name: 'Action',
            isActive: true,
            createdAt: new DateTime('2026-05-19 10:00:00'),
        );

        $input = new ListGenresInputDTO(
            name: 'Act',
            page: 2,
            perPage: 10,
            order: 'ASC',
        );

        $paginator = Mockery::mock(PaginationInterface::class);
        $paginator->shouldReceive('items')->once()->andReturn([$genre]);
        $paginator->shouldReceive('total')->once()->andReturn(11);
        $paginator->shouldReceive('currentPage')->once()->andReturn(2);
        $paginator->shouldReceive('lastPage')->once()->andReturn(2);
        $paginator->shouldReceive('perPage')->once()->andReturn(10);

        $genreRepository = Mockery::mock(GenreRepositoryInterface::class);
        $genreRepository
            ->shouldReceive('paginate')
            ->once()
            ->with('Act', 'ASC', 2, 10)
            ->andReturn($paginator);

        $usecase = new ListGenresUsecase($genreRepository);

        $result = $usecase($input);

        $this->assertInstanceOf(ListGenresOutputDTO::class, $result);
        $this->assertSame(11, $result->total);
        $this->assertSame(2, $result->currentPage);
        $this->assertSame(2, $result->lastPage);
        $this->assertSame(10, $result->perPage);
        $this->assertSame([
            [
                'id' => (string) $genreId,
                'name' => 'Action',
                'isActive' => true,
                'createdAt' => '2026-05-19 10:00:00',
            ],
        ], $result->items);
    }

    public function test_list_genres_uses_default_input_values(): void
    {
        $input = new ListGenresInputDTO;

        $paginator = Mockery::mock(PaginationInterface::class);
        $paginator->shouldReceive('items')->once()->andReturn([]);
        $paginator->shouldReceive('total')->once()->andReturn(0);
        $paginator->shouldReceive('currentPage')->once()->andReturn(1);
        $paginator->shouldReceive('lastPage')->once()->andReturn(1);
        $paginator->shouldReceive('perPage')->once()->andReturn(10);

        $genreRepository = Mockery::mock(GenreRepositoryInterface::class);
        $genreRepository
            ->shouldReceive('paginate')
            ->once()
            ->with('', 'DESC', 1, 10)
            ->andReturn($paginator);

        $usecase = new ListGenresUsecase($genreRepository);

        $result = $usecase($input);

        $this->assertSame([], $result->items);
        $this->assertSame(0, $result->total);
        $this->assertSame(1, $result->currentPage);
        $this->assertSame(1, $result->lastPage);
        $this->assertSame(10, $result->perPage);
    }
}
