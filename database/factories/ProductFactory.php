<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
            "description" => fake()->words(15, true),
            "price" => 100.99,
            "count" => fake()->randomNumber(3, true),
            "brand_id" => fake()->numberBetween(1, 5),
            "category_id" => fake()->numberBetween(1, 5),
            "user_id" => fake()->numberBetween(1, 10),
            "is_active" => 1,
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }
}
