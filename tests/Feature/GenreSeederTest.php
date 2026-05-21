<?php

namespace Tests\Feature;

use App\Models\Genre;
use Database\Seeders\CategoryGenreSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\GenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;

class GenreSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_genre_factory_creates_a_valid_genre(): void
    {
        $genre = Genre::factory()->create();

        $this->assertTrue(RamseyUuid::isValid($genre->id));
        $this->assertNotEmpty($genre->name);

        $this->assertDatabaseHas(Genre::class, [
            'id' => $genre->id,
            'name' => $genre->name,
            'is_active' => $genre->is_active,
        ]);
    }

    public function test_genre_seeders_create_genres_and_category_links(): void
    {
        $this->seed(CategorySeeder::class);
        $this->seed(GenreSeeder::class);
        $this->seed(CategoryGenreSeeder::class);

        $this->assertDatabaseCount('genres', 10);
        $this->assertDatabaseHas(Genre::class, [
            'name' => 'Action',
            'is_active' => true,
        ]);
        $this->assertDatabaseCount('category_genre', 30);

        $genre = Genre::query()->where('name', 'Action')->firstOrFail();

        $this->assertCount(3, $genre->categories);
    }
}
