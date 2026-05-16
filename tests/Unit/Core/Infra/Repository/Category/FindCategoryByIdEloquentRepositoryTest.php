<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repository\Category\FindCategoryByIdEloquentRepository;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindCategoryByIdEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_a_category_by_id(): void
    {
        $model = Category::factory()->create([
            'name' => 'Movies',
            'description' => 'Movie category',
            'is_active' => true,
        ]);

        $repository = new FindCategoryByIdEloquentRepository;

        $result = $repository->findById($model->id);

        $this->assertInstanceOf(CategoryEntity::class, $result);
        $this->assertSame($model->id, $result->id());
        $this->assertSame('Movies', $result->name);
        $this->assertSame('Movie category', $result->description);
        $this->assertTrue($result->isActive);
    }

    public function test_it_returns_null_when_category_does_not_exist(): void
    {
        $repository = new FindCategoryByIdEloquentRepository;

        $result = $repository->findById((string) UuidResolver::random());

        $this->assertNull($result);
    }
}
