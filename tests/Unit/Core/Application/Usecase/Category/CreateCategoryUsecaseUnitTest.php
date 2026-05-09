<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Application\Usecase\Category;

use App\Core\Application\DTO\Category\CreateCategoryDTO;
use App\Core\Application\Usecase\Category\CreateCategoryUsecase;
use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\CategoryRepositoryInterface;
use App\Core\Domain\Resolver\UuidResolver;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateCategoryUsecaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testCreateNewCategory(): void
    {
        $categoryId = UuidResolver::random();
        $categoryName = 'Test Category';
        $categoryDescription = 'Test Description';
        $isActive = true;

        $input = Mockery::mock(CreateCategoryDTO::class);
        $input->name = $categoryName;
        $input->description = $categoryDescription;
        $input->isActive = $isActive;

        $savedCategory = new CategoryEntity(
            id: $categoryId,
            name: $categoryName,
            description: $categoryDescription,
            isActive: $isActive
        );

        $categoryRepository = Mockery::mock(CategoryRepositoryInterface::class);

        $categoryRepository
            ->shouldReceive('insert')
            ->once()
            ->with(Mockery::on(function (CategoryEntity $category) use (
                $categoryName,
                $categoryDescription,
                $isActive
            ) {
                return $category->name === $categoryName
                    && $category->description === $categoryDescription
                    && $category->isActive === $isActive;
            }))
            ->andReturn($savedCategory);

        $usecase = new CreateCategoryUsecase($categoryRepository);

        $result = $usecase($input);

        $this->assertInstanceOf(CategoryEntity::class, $result);
        $this->assertSame((string) $categoryId, $result->id());
        $this->assertSame($categoryName, $result->name);
        $this->assertSame($categoryDescription, $result->description);
        $this->assertTrue($result->isActive);
    }
}
