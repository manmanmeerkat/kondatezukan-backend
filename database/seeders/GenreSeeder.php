<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run()
    {

        $genres = [
            ['name' => '和食'],
            ['name' => '洋食'],
            ['name' => '中華'],
            ['name' => 'その他'],
        ];


        DB::table('genres')->insert($genres);
    }
}
