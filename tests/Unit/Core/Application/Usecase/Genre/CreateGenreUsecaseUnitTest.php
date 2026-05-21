<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\Genre;

use App\Core\Application\DTO\Genre\CreateGenreInputDTO;
use App\Core\Application\DTO\Genre\CreateGenreOutputDTO;
use App\Core\Application\Interfaces\Service\ValidateCategoryIdServiceInterface;
use App\Core\Application\Usecase\Genre\CreateGenreUsecase;
use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\GenreRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\CategoryNotFoundException;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateGenreUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_create_new_genre_with_categories(): void
    {
        $genreId = UuidResolver::random();
        $firstCategoryId = (string) UuidResolver::random();
        $secondCategoryId = (string) UuidResolver::random();

        $input = new CreateGenreInputDTO(
            name: 'Action',
            categoriesId: [$firstCategoryId, $secondCategoryId],
            isActive: false,
        );

        $savedGenre = new GenreEntity(
            id: $genreId,
            name: 'Action',
            isActive: false,
            createdAt: new DateTime('2026-05-20 10:00:00'),
        );

        $repository = Mockery::mock(GenreRepositoryInterface::class);
        $validate = Mockery::mock(ValidateCategoryIdServiceInterface::class);

        $validate
            ->shouldReceive('validate')
            ->once()
            ->with([$firstCategoryId, $secondCategoryId]);

        $repository
            ->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(
                fn (GenreEntity $genre): bool => $genre->name === 'Action'
                    && $genre->isActive === false
                    && $genre->categoriesId === [$firstCategoryId, $secondCategoryId]
            ))
            ->andReturn($savedGenre);

        $usecase = new CreateGenreUsecase($repository, $validate);

        $result = $usecase($input);

        $this->assertInstanceOf(CreateGenreOutputDTO::class, $result);
        $this->assertSame((string) $genreId, $result->id);
        $this->assertSame('Action', $result->name);
        $this->assertFalse($result->isActive);
        $this->assertSame('2026-05-20 10:00:00', $result->createdAt);
    }

    public function test_it_does_not_insert_genre_when_category_validation_fails(): void
    {
        $categoryId = (string) UuidResolver::random();

        $input = new CreateGenreInputDTO(
            name: 'Action',
            categoriesId: [$categoryId],
        );

        $repository = Mockery::mock(GenreRepositoryInterface::class);
        $validate = Mockery::mock(ValidateCategoryIdServiceInterface::class);

        $validate
            ->shouldReceive('validate')
            ->once()
            ->with([$categoryId])
            ->andThrow(new CategoryNotFoundException);

        $repository
            ->shouldReceive('insert')
            ->never();

        $usecase = new CreateGenreUsecase($repository, $validate);

        $this->expectException(CategoryNotFoundException::class);

        $usecase($input);
    }

    public function test_it_adds_each_category_only_once(): void
    {
        $genreId = UuidResolver::random();
        $categoryId = (string) UuidResolver::random();

        $input = new CreateGenreInputDTO(
            name: 'Action',
            categoriesId: [$categoryId, $categoryId],
        );

        $savedGenre = new GenreEntity(
            id: $genreId,
            name: 'Action',
            createdAt: new DateTime('2026-05-20 10:00:00'),
        );

        $repository = Mockery::mock(GenreRepositoryInterface::class);
        $validate = Mockery::mock(ValidateCategoryIdServiceInterface::class);

        $validate
            ->shouldReceive('validate')
            ->once()
            ->with([$categoryId, $categoryId]);

        $repository
            ->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(
                fn (GenreEntity $genre): bool => $genre->categoriesId === [$categoryId]
            ))
            ->andReturn($savedGenre);

        $usecase = new CreateGenreUsecase($repository, $validate);

        $result = $usecase($input);

        $this->assertSame((string) $genreId, $result->id);
    }
}
