<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Movies',
            'description' => 'Movie catalog category',
            'is_active' => true,
        ]);

        Category::factory(9)->create();
    }
}
