<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->word(),
            'quantity'    => $this->faker->numberBetween(1, 100),
            'price'       => $this->faker->randomFloat(2, 1000, 500000),
            'category_id' => 1,
        ];
    }
}