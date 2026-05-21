<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Category;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repositories\EloquentRepository\Category\DeleteCategoryEloquentRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCategoryEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_category(): void
    {
        $category = Category::factory()->create([
            'name' => 'Movies',
        ]);

        $repository = new DeleteCategoryEloquentRepository;

        $result = $repository->delete($category->id);

        $this->assertTrue($result);
        $this->assertSoftDeleted(Category::class, [
            'id' => $category->id,
        ]);
    }

    public function test_it_throws_exception_when_category_does_not_exist(): void
    {
        $repository = new DeleteCategoryEloquentRepository;

        $this->expectException(ModelNotFoundException::class);

        $repository->delete((string) UuidResolver::random());
    }
}
