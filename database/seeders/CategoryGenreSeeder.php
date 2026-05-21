<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class CategoryGenreSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->limit(3)->get();

        if ($categories->isEmpty()) {
            $categories = Category::factory(3)->create();
        }

        $genres = Genre::query()->limit(10)->get();

        if ($genres->isEmpty()) {
            $genres = Genre::factory(10)->create();
        }

        $categoryIds = $categories->pluck('id')->all();

        $genres->each(function (Genre $genre) use ($categoryIds): void {
            $genre->categories()->syncWithoutDetaching($categoryIds);
        });
    }
}
