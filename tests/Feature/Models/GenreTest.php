<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genre;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    private $genres;
    private $categories;

    public function setUp(): void
    {
        parent::setUp();

        // テストデータを作成する前にIDカウンタをリセット
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Genre::query()->truncate();
        Category::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ジャンルを作成
        $this->genres = Genre::factory()->createMany([
            ['name' => '和食'],
            ['name' => '洋食'],
            ['name' => '中華'],
            ['name' => 'その他'],
        ]);

        // カテゴリーを作成
        $this->categories = Category::factory()->createMany([
            ['name' => '主菜'],
            ['name' => '副菜'],
            ['name' => '汁物'],
            ['name' => 'その他'],
        ]);

        User::factory()->create();
    }

    public function test_ジャンルは複数のレシピを持つことができる()
    {
        $genre = Genre::factory()->create();
        $dish1 = Dish::factory()->create(['genre_id' => $genre->id]);
        $dish2 = Dish::factory()->create(['genre_id' => $genre->id]);

        $this->assertCount(2, $genre->dishes);
        $this->assertInstanceOf(Dish::class, $genre->dishes->first());
    }
}
