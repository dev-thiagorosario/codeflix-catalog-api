<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Infra\Repository\Genre;

use App\Core\Domain\Entity\GenreEntity;
use App\Core\Infra\Repositories\EloquentRepository\Genre\UpdateGenreEloquentRepository;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateGenreEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_genre_and_syncs_categories(): void
    {
        $genreModel = Genre::factory()->create([
            'name' => 'Action',
            'is_active' => true,
        ]);

        $categoryToKeep = Category::factory()->create();
        $categoryToRemove = Category::factory()->create();
        $categoryToAdd = Category::factory()->create();

        $genreModel->categories()->attach([
            $categoryToKeep->id,
            $categoryToRemove->id,
        ]);

        $genre = new GenreEntity(
            id: $genreModel->id,
            name: 'Drama',
            isActive: false,
            categoriesId: [
                $categoryToKeep->id,
                $categoryToAdd->id,
            ],
        );

        $repository = new UpdateGenreEloquentRepository;

        $result = $repository->update($genre);

        $this->assertSame($genreModel->id, $result->id());
        $this->assertSame('Drama', $result->name);
        $this->assertFalse($result->isActive);
        $this->assertEqualsCanonicalizing([
            $categoryToKeep->id,
            $categoryToAdd->id,
        ], $result->categoriesId);

        $this->assertDatabaseHas(Genre::class, [
            'id' => $genreModel->id,
            'name' => 'Drama',
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('category_genre', [
            'genre_id' => $genreModel->id,
            'category_id' => $categoryToKeep->id,
        ]);
        $this->assertDatabaseHas('category_genre', [
            'genre_id' => $genreModel->id,
            'category_id' => $categoryToAdd->id,
        ]);
        $this->assertDatabaseMissing('category_genre', [
            'genre_id' => $genreModel->id,
            'category_id' => $categoryToRemove->id,
        ]);
    }

    public function test_it_detaches_all_categories_when_entity_has_no_categories(): void
    {
        $genreModel = Genre::factory()->create();
        $category = Category::factory()->create();

        $genreModel->categories()->attach($category->id);

        $genre = new GenreEntity(
            id: $genreModel->id,
            name: 'Documentary',
            categoriesId: [],
        );

        $repository = new UpdateGenreEloquentRepository;

        $result = $repository->update($genre);

        $this->assertSame([], $result->categoriesId);
        $this->assertDatabaseMissing('category_genre', [
            'genre_id' => $genreModel->id,
            'category_id' => $category->id,
        ]);
    }
}
