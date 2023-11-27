<?php

namespace Database\Seeders;

// database/seeders/DishSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Dish;

class DishSeeder extends Seeder
{
    public function run()
    {
        // ダミーデータを生成して dishes テーブルに挿入
        Dish::factory()->count(100)->create(); // 10個のダミーレシピを生成
    }
}
