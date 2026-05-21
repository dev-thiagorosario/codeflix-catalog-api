<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\UpdateGenreInputDTO;
use App\Core\Application\DTO\Genre\UpdateGenreOutputDTO;
use App\Core\Application\Interfaces\Service\ValidateCategoryIdServiceInterface;
use App\Core\Application\Interfaces\TransactionInterface;
use App\Core\Application\Usecase\Genre\UpdateGenreUsecase;
use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateGenreUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_updates_genre_and_removes_categories(): void
    {
        $genreId = UuidResolver::random();
        $categoryIdToKeep = (string) UuidResolver::random();
        $categoryIdToRemove = (string) UuidResolver::random();
        $categoryIdToAdd = (string) UuidResolver::random();

        $genre = new GenreEntity(
            id: $genreId,
            name: 'Action',
            categoriesId: [$categoryIdToKeep, $categoryIdToRemove],
            updatedAt: new DateTime('2026-05-20 10:00:00'),
        );

        $input = new UpdateGenreInputDTO(
            id: (string) $genreId,
            name: 'Drama',
            categoriesIdsToAdd: [$categoryIdToAdd],
            isActive: false,
            categoriesIdsToRemove: [$categoryIdToRemove],
        );

        $repository = Mockery::mock(GenreRepositoryInterface::class);
        $validate = Mockery::mock(ValidateCategoryIdServiceInterface::class);
        $transaction = Mockery::mock(TransactionInterface::class);

        $repository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $genreId)
            ->andReturn($genre);

        $validate
            ->shouldReceive('validate')
            ->once()
            ->with([$categoryIdToAdd]);

        $repository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::on(
                fn (GenreEntity $genre): bool => $genre->name === 'Drama'
                    && $genre->isActive === false
                    && $genre->categoriesId === [$categoryIdToKeep, $categoryIdToAdd]
            ))
            ->andReturnUsing(fn (GenreEntity $genre): GenreEntity => $genre);

        $transaction
            ->shouldReceive('commit')
            ->once();

        $transaction
            ->shouldReceive('rollback')
            ->never();

        $usecase = new UpdateGenreUsecase($repository, $validate, $transaction);

        $result = $usecase($input);

        $this->assertInstanceOf(UpdateGenreOutputDTO::class, $result);
        $this->assertSame((string) $genreId, $result->id);
        $this->assertSame('Drama', $result->name);
        $this->assertFalse($result->isActive);
    }

    public function test_it_allows_categories_ids_to_remove_to_be_null(): void
    {
        $genreId = UuidResolver::random();
        $categoryId = (string) UuidResolver::random();

        $genre = new GenreEntity(
            id: $genreId,
            name: 'Action',
            categoriesId: [$categoryId],
        );

        $input = new UpdateGenreInputDTO(
            id: (string) $genreId,
            name: 'Action Updated',
            categoriesIdsToAdd: null,
            categoriesIdsToRemove: null,
        );

        $repository = Mockery::mock(GenreRepositoryInterface::class);
        $validate = Mockery::mock(ValidateCategoryIdServiceInterface::class);
        $transaction = Mockery::mock(TransactionInterface::class);

        $repository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $genreId)
            ->andReturn($genre);

        $validate
            ->shouldReceive('validate')
            ->once()
            ->with([]);

        $repository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::on(
                fn (GenreEntity $genre): bool => $genre->name === 'Action Updated'
                    && $genre->categoriesId === [$categoryId]
            ))
            ->andReturnUsing(fn (GenreEntity $genre): GenreEntity => $genre);

        $transaction
            ->shouldReceive('commit')
            ->once();

        $transaction
            ->shouldReceive('rollback')
            ->never();

        $usecase = new UpdateGenreUsecase($repository, $validate, $transaction);

        $result = $usecase($input);

        $this->assertSame((string) $genreId, $result->id);
        $this->assertSame('Action Updated', $result->name);
    }
}
