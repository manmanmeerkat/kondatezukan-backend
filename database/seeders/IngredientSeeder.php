<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('ingredients')->insert([
                'name' => 'Ingredient ' . $i,
                'category' => 'Category ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
