<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
        ];
    }

    // ファクトリが実行されたときに呼ばれるメソッド
    public function configure()
    {
        return $this->afterMaking(function (Genre $genre) {
            // データベースの設定により、この行が効果を持つかは状況によります
            $genre->id = 1;
        });
    }
}
