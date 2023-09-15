<?php

namespace Database\Seeders;

// database/seeders/RecipeSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        // ダミーデータを生成して recipes テーブルに挿入
        Recipe::factory()->count(100)->create(); // 10個のダミーレシピを生成
    }
}
