<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\UpdateCategoryInputDTO;
use App\Core\Application\DTO\Category\UpdateCategoryOutputDTO;
use App\Core\Application\Usecase\Category\UpdateCategoryUsecase;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\CategoryNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateCategoryUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_update_category(): void
    {
        $categoryId = UuidResolver::random();
        $category = new CategoryEntity(
            id: $categoryId,
            name: 'Old Category',
            description: 'Old Description',
            isActive: false,
            createdAt: '2026-05-12 10:00:00',
            updatedAt: '2026-05-12 10:00:00',
        );

        $input = new UpdateCategoryInputDTO(
            id: (string) $categoryId,
            name: 'Updated Category',
            description: 'Updated Description',
            isActive: true,
        );

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $categoryRepository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $categoryId)
            ->andReturn($category);

        $categoryRepository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::on(function (CategoryEntity $category): bool {
                return $category->name === 'Updated Category'
                    && $category->description === 'Updated Description'
                    && $category->isActive === true
                    && $category->updatedAt() !== '2026-05-12 10:00:00';
            }))
            ->andReturn($category);

        $usecase = new UpdateCategoryUsecase($categoryRepository);

        $result = $usecase($input);

        $this->assertInstanceOf(UpdateCategoryOutputDTO::class, $result);
        $this->assertSame((string) $categoryId, $result->id);
        $this->assertSame('Updated Category', $result->name);
        $this->assertSame('Updated Description', $result->description);
        $this->assertTrue($result->isActive);
        $this->assertSame($category->updatedAt(), $result->updatedAt);
    }

    public function test_update_category_to_inactive(): void
    {
        $categoryId = UuidResolver::random();
        $category = new CategoryEntity(
            id: $categoryId,
            name: 'Old Category',
            description: 'Old Description',
            isActive: true,
            createdAt: '2026-05-12 10:00:00',
            updatedAt: '2026-05-12 10:00:00',
        );

        $input = new UpdateCategoryInputDTO(
            id: (string) $categoryId,
            name: 'Updated Category',
            description: 'Updated Description',
            isActive: false,
        );

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $categoryRepository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $categoryId)
            ->andReturn($category);

        $categoryRepository
            ->shouldReceive('update')
            ->once()
            ->with(Mockery::on(fn (CategoryEntity $category): bool => $category->isActive === false))
            ->andReturn($category);

        $usecase = new UpdateCategoryUsecase($categoryRepository);

        $result = $usecase($input);

        $this->assertFalse($result->isActive);
    }

    public function test_throw_exception_when_category_does_not_exist(): void
    {
        $categoryId = (string) UuidResolver::random();
        $input = new UpdateCategoryInputDTO(
            id: $categoryId,
            name: 'Updated Category',
            description: 'Updated Description',
        );

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $categoryRepository
            ->shouldReceive('findById')
            ->once()
            ->with($categoryId)
            ->andReturnNull();

        $categoryRepository
            ->shouldNotReceive('update');

        $usecase = new UpdateCategoryUsecase($categoryRepository);

        $this->expectException(CategoryNotFoundException::class);
        $this->expectExceptionMessage('Categoria Não Encontrada');

        $usecase($input);
    }
}
