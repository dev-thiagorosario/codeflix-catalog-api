<?php

namespace Tests\Unit\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\DeleteCategoryInputDTO;
use App\Core\Application\Usecase\Category\DeleteCategoryUsecase;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Exception\CategoryNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class DeleteCategoryUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_delete_category(): void
    {
        $categoryId = UuidResolver::random();
        $category = new CategoryEntity(
            id: $categoryId,
            name: 'Category',
            description: 'Description',
            createdAt: '2026-05-12 10:00:00',
            updatedAt: '2026-05-12 10:00:00',
        );
        $input = new DeleteCategoryInputDTO((string) $categoryId);

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $categoryRepository
            ->shouldReceive('findById')
            ->once()
            ->with((string) $categoryId)
            ->andReturn($category);

        $categoryRepository
            ->shouldReceive('delete')
            ->once()
            ->with((string) $categoryId)
            ->andReturnTrue();

        $categoryRepository
            ->shouldNotReceive('update');

        $usecase = new DeleteCategoryUsecase($categoryRepository);

        $usecase($input);

        $this->assertNull($category->deletedAt());
    }

    public function test_throw_exception_when_category_does_not_exist(): void
    {
        $categoryId = (string) UuidResolver::random();
        $input = new DeleteCategoryInputDTO($categoryId);

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $categoryRepository
            ->shouldReceive('findById')
            ->once()
            ->with($categoryId)
            ->andReturnNull();

        $categoryRepository
            ->shouldNotReceive('update');
        $categoryRepository
            ->shouldNotReceive('delete');

        $usecase = new DeleteCategoryUsecase($categoryRepository);

        $this->expectException(CategoryNotFoundException::class);
        $this->expectExceptionMessage('Categoria Não Encontrada');

        $usecase($input);
    }
}
