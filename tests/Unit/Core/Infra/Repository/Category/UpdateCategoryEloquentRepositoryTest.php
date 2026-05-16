<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repository\Category\UpdateCategoryEloquentRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCategoryEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_category(): void
    {
        $model = Category::factory()->create([
            'name' => 'Movies',
            'description' => 'Old description',
            'is_active' => true,
        ]);

        $category = new CategoryEntity(
            id: $model->id,
            name: 'Series',
            description: 'Updated description',
            isActive: false,
        );

        $repository = new UpdateCategoryEloquentRepository;

        $result = $repository->update($category);

        $this->assertSame($model->id, $result->id());
        $this->assertSame('Series', $result->name);
        $this->assertSame('Updated description', $result->description);
        $this->assertFalse($result->isActive);

        $this->assertDatabaseHas(Category::class, [
            'id' => $model->id,
            'name' => 'Series',
            'description' => 'Updated description',
            'is_active' => false,
        ]);
    }

    public function test_it_throws_exception_when_category_does_not_exist(): void
    {
        $category = new CategoryEntity(
            id: UuidResolver::random(),
            name: 'Series',
            description: 'Updated description',
            isActive: false,
        );

        $repository = new UpdateCategoryEloquentRepository;

        $this->expectException(ModelNotFoundException::class);

        $repository->update($category);
    }
}
