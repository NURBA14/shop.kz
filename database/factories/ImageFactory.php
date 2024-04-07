<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "url" => fake()->imageUrl(640, 480, "cars", true),
            "product_id" => fake()->numberBetween(1, 10),
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
