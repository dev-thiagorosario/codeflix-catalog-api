<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Service;

use App\Core\Application\Service\ValidateCategoryIdService;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\CategoryNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class ValidateCategoryIdServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_validates_existing_category_ids(): void
    {
        $firstCategoryId = (string) UuidResolver::random();
        $secondCategoryId = (string) UuidResolver::random();

        $repository = Mockery::mock(CategoryRepositoryInterface::class);
        $repository
            ->shouldReceive('getIdsByCategoryIds')
            ->once()
            ->with([$firstCategoryId, $secondCategoryId])
            ->andReturn([$firstCategoryId, $secondCategoryId]);

        $service = new ValidateCategoryIdService($repository);

        $service->validate([$firstCategoryId, $secondCategoryId]);

        $this->assertTrue(true);
    }

    public function test_it_ignores_duplicate_category_ids_when_validating(): void
    {
        $categoryId = (string) UuidResolver::random();

        $repository = Mockery::mock(CategoryRepositoryInterface::class);
        $repository
            ->shouldReceive('getIdsByCategoryIds')
            ->once()
            ->with([$categoryId])
            ->andReturn([$categoryId]);

        $service = new ValidateCategoryIdService($repository);

        $service->validate([$categoryId, $categoryId]);

        $this->assertTrue(true);
    }

    public function test_it_does_not_query_repository_when_no_category_ids_are_provided(): void
    {
        $repository = Mockery::mock(CategoryRepositoryInterface::class);
        $repository
            ->shouldReceive('getIdsByCategoryIds')
            ->never();

        $service = new ValidateCategoryIdService($repository);

        $service->validate([]);

        $this->assertTrue(true);
    }

    public function test_it_throws_exception_when_any_category_id_does_not_exist(): void
    {
        $existingCategoryId = (string) UuidResolver::random();
        $missingCategoryId = (string) UuidResolver::random();

        $repository = Mockery::mock(CategoryRepositoryInterface::class);
        $repository
            ->shouldReceive('getIdsByCategoryIds')
            ->once()
            ->with([$existingCategoryId, $missingCategoryId])
            ->andReturn([$existingCategoryId]);

        $service = new ValidateCategoryIdService($repository);

        $this->expectException(CategoryNotFoundException::class);

        $service->validate([$existingCategoryId, $missingCategoryId]);
    }
}
