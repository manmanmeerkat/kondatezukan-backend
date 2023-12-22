<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            ['name' => '主菜'],
            ['name' => '副菜'],
            ['name' => '汁物'],
            ['name' => 'その他'],
        ];


        DB::table('categories')->insert($category);
    }
}
