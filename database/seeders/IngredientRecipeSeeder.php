<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('ingredient_recipe')->insert([
                'ingredient_id' => rand(1, 100), // Replace with actual ingredient IDs.
                'recipe_id' => rand(202, 300), // Replace with actual recipe IDs.
            ]);
        }
    }
}
