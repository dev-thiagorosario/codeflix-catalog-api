<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Domain\Repository\PaginationInterface;
use App\Core\Infra\Repositories\EloquentRepository\Genre\FindAllGenresEloquentRepository;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindAllGenresEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_all_genres_ordered_by_name_desc(): void
    {
        Genre::factory()->create(['name' => 'Alpha']);
        Genre::factory()->create(['name' => 'Streaming']);
        Genre::factory()->create(['name' => 'Zeta']);

        $repository = new FindAllGenresEloquentRepository;

        $result = $repository->findAll();

        $this->assertContainsOnlyInstancesOf(GenreEntity::class, $result);
        $this->assertSame(['Zeta', 'Streaming', 'Alpha'], array_map(
            fn (GenreEntity $genre): string => $genre->name,
            $result,
        ));
    }

    public function test_it_filters_genres_by_name_and_orders_results(): void
    {
        Genre::factory()->create(['name' => 'Video Games']);
        Genre::factory()->create(['name' => 'Music']);
        Genre::factory()->create(['name' => 'Video Courses']);

        $repository = new FindAllGenresEloquentRepository;

        $result = $repository->findAll(filter: 'Video', order: 'ASC');

        $this->assertContainsOnlyInstancesOf(GenreEntity::class, $result);
        $this->assertSame(['Video Courses', 'Video Games'], array_map(
            fn (GenreEntity $genre): string => $genre->name,
            $result,
        ));
    }

    public function test_it_paginates_filtered_genres(): void
    {
        Genre::factory()->create(['name' => 'Video Games']);
        Genre::factory()->create(['name' => 'Music']);
        Genre::factory()->create(['name' => 'Video Courses']);

        $repository = new FindAllGenresEloquentRepository;

        $result = $repository->paginate(filter: 'Video', order: 'ASC', page: 1, perPage: 1);

        $this->assertInstanceOf(PaginationInterface::class, $result);
        $this->assertSame(2, $result->total());
        $this->assertSame(1, $result->currentPage());
        $this->assertSame(2, $result->lastPage());
        $this->assertSame(1, $result->perPage());
        $this->assertSame(1, $result->from());
        $this->assertSame(1, $result->to());
        $this->assertContainsOnlyInstancesOf(GenreEntity::class, $result->items());
        $this->assertSame('Video Courses', $result->items()[0]->name);
    }
}
