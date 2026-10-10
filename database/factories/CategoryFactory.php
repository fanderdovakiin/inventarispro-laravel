<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categoryName = fake()->unique()->words(2, true);

        return [
            'category_name' => Str::title($categoryName),
            'description' => fake()->optional()->sentence(),
            'slug' => Str::slug($categoryName),
        ];
    }
}
