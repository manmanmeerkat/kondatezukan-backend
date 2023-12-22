<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ingredientsテーブルにダミーデータを挿入
        DB::table('ingredients')->insert([
            [
                'name' => 'ダミー食材1',
                'category' => '野菜',
            ],
            [
                'name' => 'ダミー食材2',
                'category' => '肉',
            ],
            [
                'name' => 'ダミー食材3',
                'category' => '野菜',
            ],
            [
                'name' => 'ダミー食材4',
                'category' => '肉',
            ],
            [
                'name' => 'ダミー食材5',
                'category' => '野菜',
            ],
            [
                'name' => 'ダミー食材6',
                'category' => '肉',
            ],
            // 他のダミーデータも追加できます
        ]);
    }
}
