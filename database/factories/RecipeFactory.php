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
            'genre_id' => $this->faker->randomNumber([1, 2, 3, 4]),
            'category_id' => $this->faker->randomNumber([1, 2, 3, 4]),
            'genre_id' => function () {
                return \App\Models\Genre::inRandomOrder()->first()->id;
            },
            'category_id' => function () {
                return \App\Models\Category::inRandomOrder()->first()->id;
            },
            'user_id' => function () {
                return \App\Models\User::inRandomOrder()->first()->id;
            },
            // 他のレシピ情報を追加
        ];
    }
}
