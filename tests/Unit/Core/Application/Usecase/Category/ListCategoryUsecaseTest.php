<?php

namespace Tests\Unit\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\ListCategoryInputDTO;
use App\Core\Application\DTO\Category\ListCategoryOutputDTO;
use App\Core\Application\Usecase\Category\ListCategoryUsecase;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Domain\Resolver\UuidResolver;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListCategoryUsecaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_list_categories(): void
    {
        $categoryId = UuidResolver::random();
        $category = new CategoryEntity(
            id: $categoryId,
            name: 'Test Category',
            description: 'Test Description',
            isActive: true,
            createdAt: '2026-05-12 10:00:00',
        );

        $input = new ListCategoryInputDTO(
            name: 'Test',
            page: 2,
            perPage: 10,
            order: 'ASC',
        );

        $paginator = Mockery::mock(PaginationInterface::class);
        $paginator->shouldReceive('items')->once()->andReturn([$category]);
        $paginator->shouldReceive('total')->once()->andReturn(11);
        $paginator->shouldReceive('currentPage')->once()->andReturn(2);
        $paginator->shouldReceive('lastPage')->once()->andReturn(2);
        $paginator->shouldReceive('perPage')->once()->andReturn(10);

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $categoryRepository
            ->shouldReceive('paginate')
            ->once()
            ->with('Test', 'ASC', 2, 10)
            ->andReturn($paginator);

        $usecase = new ListCategoryUsecase($categoryRepository);

        $result = $usecase($input);

        $this->assertInstanceOf(ListCategoryOutputDTO::class, $result);
        $this->assertSame(11, $result->total);
        $this->assertSame(2, $result->currentPage);
        $this->assertSame(2, $result->lastPage);
        $this->assertSame(10, $result->perPage);
        $this->assertSame([
            [
                'id' => (string) $categoryId,
                'name' => 'Test Category',
                'description' => 'Test Description',
                'isActive' => true,
                'createdAt' => '2026-05-12 10:00:00',
            ],
        ], $result->items);
    }
}
