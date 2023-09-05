<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'genre' => $this->faker->randomElement(['和食', '洋食', '中華', 'その他']),
            'type' => $this->faker->randomElement(['主菜', '副菜', '汁物']),
        ];
    }
}
