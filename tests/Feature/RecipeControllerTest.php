<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Genre;
use App\Models\Category;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;



class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザーに関連付けられた料理をすべて取得できる()
    {
        // ジャンルIDが1のデータをデータベースに挿入
        Genre::create(['id' => 1, 'name' => '和食']);
        Category::create(['id' => 1, 'name' => '主菜']);

        // テストユーザーを作成
        $user = User::factory()->create();

        // 認証済みのユーザーとしてログイン
        Auth::login($user);


        // テスト用のレシピを作成
        $recipe = Recipe::factory(3)->create(['user_id' => $user->id, 'genre_id' => 1, 'category_id' => 1]);

        // レシピ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/all-my-dish');

        // レスポンスの検証
        $response->assertStatus(200)
         ->assertJson(['recipes' => $recipe->toArray()]);

    }

    public function testGetIngredientsForRecipe()
    {

        // ジャンルIDが1のデータをデータベースに挿入
        Genre::create(['id' => 1, 'name' => '和食']);
        Category::create(['id' => 1, 'name' => '主菜']);

        // テストユーザーを作成
        $user = User::factory()->create();

        // 認証済みのユーザーとしてログイン
        Auth::login($user);

        // テスト用のレシピと材料を作成
        $recipe = Recipe::factory()->create();
        $ingredients = Ingredient::factory()->create(['id' => $recipe->id , 'name' => 'illum','user_id' => $user->id]);

        $recipe->ingredients()->attach($ingredients);
        // レシピが存在する場合のテスト
        $response = $this->json('GET', '/api/recipes/' . $recipe->id . '/ingredients');
        $response->assertStatus(200)
             ->assertJson(['ingredients' => [
                [
                    'id' => 4,
                    'name' => 'illum',
                    'user_id' => 2,
                    'created_at' => '2023-11-14T12:25:44.000000Z',
                    'updated_at' => '2023-11-14T12:25:44.000000Z',
                    'pivot' => [
                        'recipe_id' => 4,
                        'ingredient_id' => 4,
                    ],
                ],
            ]]);
        // レシピが存在しない場合のテスト
        $nonExistingRecipeId = 999;
        $response = $this->json('GET', '/api/recipe/' . $nonExistingRecipeId . '/ingredients');
        $response->assertStatus(404)
                 ->assertJson(['message' => 'Recipe not found']);
    }
}
