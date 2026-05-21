<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        Genre::factory()->create([
            'name' => 'Action',
            'is_active' => true,
        ]);

        Genre::factory(9)->create();
    }
}
