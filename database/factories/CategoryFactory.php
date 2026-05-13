<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->optional()->sentence(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
