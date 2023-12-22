<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientDishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('ingredient_dish')->insert([
                'ingredient_id' => rand(1, 100), // Replace with actual ingredient IDs.
                'dish_id' => rand(202, 300), // Replace with actual dish IDs.
            ]);
        }
    }
}
