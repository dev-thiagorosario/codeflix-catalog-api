<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Category;

use App\Core\Domain\Resolver\UuidResolver;
use App\Core\Infra\Repositories\EloquentRepository\Category\GetIdsByCategoryIdsEloquentRepository;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetIdsByCategoryIdsEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_only_existing_category_ids(): void
    {
        $firstCategory = Category::factory()->create(['name' => 'Movies']);
        $secondCategory = Category::factory()->create(['name' => 'Series']);
        $deletedCategory = Category::factory()->create(['name' => 'Deleted']);
        $deletedCategory->delete();

        $repository = new GetIdsByCategoryIdsEloquentRepository;

        $result = $repository->getIdsByCategoryIds([
            $firstCategory->id,
            (string) UuidResolver::random(),
            $secondCategory->id,
            $deletedCategory->id,
        ]);

        $this->assertEqualsCanonicalizing([
            $firstCategory->id,
            $secondCategory->id,
        ], $result);
    }

    public function test_it_returns_an_empty_array_when_no_category_ids_are_provided(): void
    {
        $repository = new GetIdsByCategoryIdsEloquentRepository;

        $this->assertSame([], $repository->getIdsByCategoryIds([]));
    }
}
