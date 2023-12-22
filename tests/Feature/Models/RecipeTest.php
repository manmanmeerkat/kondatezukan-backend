<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\Genre;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DishTest extends TestCase
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
    }

    public function test_ジャンルが和食でカテゴリーが主菜のデータを取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 1,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_syusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_dish_has_many_ingredients()
    {
        $dish = Dish::factory()->create();
        $ingredient1 = Ingredient::factory()->create();
        $ingredient2 = Ingredient::factory()->create();

        // レシピに2つの食材をアタッチ
        $dish->ingredients()->attach([$ingredient1->id, $ingredient2->id]);

        $this->assertCount(2, $dish->ingredients);
        $this->assertInstanceOf(Ingredient::class, $dish->ingredients->first());
    }

    public function test_dish_belongs_to_genre()
    {
        $genre = Genre::factory()->create();
        $dish = Dish::factory()->create(['genre_id' => $genre->id]);

        $this->assertInstanceOf(Genre::class, $dish->genre);
    }

    public function test_dish_belongs_to_category()
    {
        $category = Category::factory()->create();
        $dish = Dish::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $dish->category);
    }

    public function test_dish_belongs_to_user()
    {
        $user = User::factory()->create();
        $dish = Dish::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $dish->user);
    }
}
