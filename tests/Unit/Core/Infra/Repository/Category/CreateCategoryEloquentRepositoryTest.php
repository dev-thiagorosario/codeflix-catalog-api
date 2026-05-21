<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repositories\EloquentRepository\Category\CreateCategoryEloquentRepository;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCategoryEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_category(): void
    {
        $category = new CategoryEntity(
            id: UuidResolver::random(),
            name: 'Movies',
            description: 'Movie category',
            isActive: true,
        );

        $repository = new CreateCategoryEloquentRepository;

        $result = $repository->insert($category);

        $this->assertSame($category->id(), $result->id());
        $this->assertSame('Movies', $result->name);
        $this->assertSame('Movie category', $result->description);
        $this->assertTrue($result->isActive);

        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id(),
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
        ]);
    }
}
