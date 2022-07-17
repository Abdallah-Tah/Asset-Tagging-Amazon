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
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'category_id' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'is_active' => $this->faker->boolean,
            'image' => $this->faker->imageUrl(100, 100),
        ];
    }
}
