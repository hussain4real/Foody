<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 2,
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Food $food) {
            $imageUrls = [
                'https://picsum.photos/200/300',
                'https://picsum.photos/200/300',
                'https://picsum.photos/200/300',
                'https://picsum.photos/200/300',

            ];

            foreach ($imageUrls as $url) {
                $food->addMediaFromUrl($url)->toMediaCollection('images');
            }
        });
    }
}
