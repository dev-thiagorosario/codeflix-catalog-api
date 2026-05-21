<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Repositories\EloquentRepository\Genre\CreateGenreEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\DeleteGenreEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\FindAllGenresEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\FindGenreByIdEloquentRepository;
use App\Core\Infra\Repositories\EloquentRepository\Genre\UpdateGenreEloquentRepository;
use App\Core\Infra\Repositories\Gateway\GenreGatewayRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class GenreGatewayRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_it_delegates_operations_to_eloquent_repositories(): void
    {
        $genre = new GenreEntity(name: 'Action');
        $updatedGenre = new GenreEntity(id: $genre->id(), name: 'Drama');
        $pagination = Mockery::mock(PaginationInterface::class);

        $createRepository = Mockery::mock(CreateGenreEloquentRepository::class);
        $findByIdRepository = Mockery::mock(FindGenreByIdEloquentRepository::class);
        $findAllRepository = Mockery::mock(FindAllGenresEloquentRepository::class);
        $updateRepository = Mockery::mock(UpdateGenreEloquentRepository::class);
        $deleteRepository = Mockery::mock(DeleteGenreEloquentRepository::class);

        $createRepository
            ->shouldReceive('insert')
            ->once()
            ->with($genre)
            ->andReturn($genre);

        $findByIdRepository
            ->shouldReceive('findById')
            ->once()
            ->with($genre->id())
            ->andReturn($genre);

        $findAllRepository
            ->shouldReceive('findAll')
            ->once()
            ->with('act', 'ASC')
            ->andReturn([$genre]);

        $findAllRepository
            ->shouldReceive('paginate')
            ->once()
            ->with('act', 'DESC', 2, 15)
            ->andReturn($pagination);

        $updateRepository
            ->shouldReceive('update')
            ->once()
            ->with($updatedGenre)
            ->andReturn($updatedGenre);

        $deleteRepository
            ->shouldReceive('delete')
            ->once()
            ->with($genre->id())
            ->andReturnTrue();

        $repository = new GenreGatewayRepository(
            $createRepository,
            $findByIdRepository,
            $findAllRepository,
            $updateRepository,
            $deleteRepository,
        );

        $this->assertSame($genre, $repository->insert($genre));
        $this->assertSame($genre, $repository->findById($genre->id()));
        $this->assertSame([$genre], $repository->findAll('act', 'ASC'));
        $this->assertSame($pagination, $repository->paginate('act', 'DESC', 2, 15));
        $this->assertSame($updatedGenre, $repository->update($updatedGenre));
        $this->assertTrue($repository->delete($genre->id()));
    }
}
