<?php

namespace Database\Factories;

// database/factories/RecipeFactory.php

// database/factories/RecipeFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    protected $model = \App\Models\Recipe::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'genre' => $this->faker->randomElement(['和食', '洋食', '中華', 'その他']),
            'category' => $this->faker->randomElement(['主菜', '副菜', '汁物', 'その他']),
            // 他のレシピ情報を追加
        ];
    }
}
