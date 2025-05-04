<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(2, true),
            'brand' => $this->faker->company,
            'price' => $this->faker->numberBetween(100, 100000),
            'description' => $this->faker->sentence,
            'condition' => $this->faker->randomElement(['良好', 'やや傷や汚れあり', '目立った傷や汚れなし', '状態が悪い']),
            'image_path' => 'dummy.jpg',
        ];
    }
}
