<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Category;

use App\Core\Domain\Entity\CategoryEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Repository\Category\FindAllCategoriesEloquentRepository;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindAllCategoriesEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_all_categories_ordered_by_name_desc(): void
    {
        Category::factory()->create(['name' => 'Alpha']);
        Category::factory()->create(['name' => 'Streaming']);
        Category::factory()->create(['name' => 'Zeta']);

        $repository = new FindAllCategoriesEloquentRepository;

        $result = $repository->findAll();

        $this->assertContainsOnlyInstancesOf(CategoryEntity::class, $result);
        $this->assertSame(['Zeta', 'Streaming', 'Alpha'], array_map(
            fn (CategoryEntity $category): string => $category->name,
            $result,
        ));
    }

    public function test_it_filters_categories_by_name_and_orders_results(): void
    {
        Category::factory()->create(['name' => 'Video Games']);
        Category::factory()->create(['name' => 'Music']);
        Category::factory()->create(['name' => 'Video Courses']);

        $repository = new FindAllCategoriesEloquentRepository;

        $result = $repository->findAll(filter: 'Video', order: 'ASC');

        $this->assertContainsOnlyInstancesOf(CategoryEntity::class, $result);
        $this->assertSame(['Video Courses', 'Video Games'], array_map(
            fn (CategoryEntity $category): string => $category->name,
            $result,
        ));
    }

    public function test_it_paginates_filtered_categories(): void
    {
        Category::factory()->create(['name' => 'Video Games']);
        Category::factory()->create(['name' => 'Music']);
        Category::factory()->create(['name' => 'Video Courses']);

        $repository = new FindAllCategoriesEloquentRepository;

        $result = $repository->paginate(filter: 'Video', order: 'ASC', page: 1, perPage: 1);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertSame(2, $result->total());
        $this->assertSame(1, $result->currentPage());
        $this->assertSame(2, $result->lastPage());
        $this->assertSame(1, $result->perPage());
        $this->assertSame(1, $result->from());
        $this->assertSame(1, $result->to());
        $this->assertContainsOnlyInstancesOf(CategoryEntity::class, $result->items());
        $this->assertSame('Video Courses', $result->items()[0]->name);
    }
}
