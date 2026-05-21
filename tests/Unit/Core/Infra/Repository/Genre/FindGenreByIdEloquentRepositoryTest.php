<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Genre;

use App\Core\Infra\Repositories\EloquentRepository\Genre\FindGenreByIdEloquentRepository;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindGenreByIdEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_a_genre_with_categories(): void
    {
        $genreModel = Genre::factory()->create([
            'name' => 'Action',
            'is_active' => true,
        ]);

        $categories = Category::factory()->count(2)->create();

        $genreModel->categories()->attach($categories->pluck('id')->all());

        $repository = new FindGenreByIdEloquentRepository;

        $result = $repository->findById($genreModel->id);

        $this->assertNotNull($result);
        $this->assertSame($genreModel->id, $result->id());
        $this->assertSame('Action', $result->name);
        $this->assertEqualsCanonicalizing(
            $categories->pluck('id')->all(),
            $result->categoriesId,
        );
    }

    public function test_it_returns_null_when_genre_does_not_exist(): void
    {
        $repository = new FindGenreByIdEloquentRepository;

        $result = $repository->findById('00000000-0000-0000-0000-000000000000');

        $this->assertNull($result);
    }
}
