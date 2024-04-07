<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "text" => fake()->paragraph(2),
            "rating" => fake()->numberBetween(1, 10),
            "product_id" => fake()->numberBetween(1, 10),
            "user_id" => fake()->numberBetween(1, 10),
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
