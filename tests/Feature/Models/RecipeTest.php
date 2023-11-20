<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Genre;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RecipeTest extends TestCase
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
        $recipes = Recipe::factory()->count(3)->create([
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
                    'id' => $recipes[0]->id,
                    'name' => $recipes[0]->name,
                    'description' => $recipes[0]->description,
                    'genre_id' => $recipes[0]->genre_id,
                    'category_id' => $recipes[0]->category_id,
                    'reference_url' => $recipes[0]->reference_url,
                    'image_path' => $recipes[0]->image_path,
                ]
            ]);
    }

    public function test_recipe_has_many_ingredients()
    {
        $recipe = Recipe::factory()->create();
        $ingredient1 = Ingredient::factory()->create();
        $ingredient2 = Ingredient::factory()->create();

        // レシピに2つの食材をアタッチ
        $recipe->ingredients()->attach([$ingredient1->id, $ingredient2->id]);

        $this->assertCount(2, $recipe->ingredients);
        $this->assertInstanceOf(Ingredient::class, $recipe->ingredients->first());
    }

    public function test_recipe_belongs_to_genre()
    {
        $genre = Genre::factory()->create();
        $recipe = Recipe::factory()->create(['genre_id' => $genre->id]);

        $this->assertInstanceOf(Genre::class, $recipe->genre);
    }

    public function test_recipe_belongs_to_category()
    {
        $category = Category::factory()->create();
        $recipe = Recipe::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $recipe->category);
    }

    public function test_recipe_belongs_to_user()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $recipe->user);
    }
}
