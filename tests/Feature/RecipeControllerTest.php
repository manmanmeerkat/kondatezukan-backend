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
        $ingredients = Ingredient::factory()->create(['id' => $recipe->id, 'name' => $user->name, 'user_id' => $user->id]);

        $recipe->ingredients()->attach($ingredients);
        // レシピが存在する場合のテスト
        $response = $this->json('GET', '/api/recipes/' . $recipe->id . '/ingredients');
        $response->assertStatus(200)
            ->assertJson(['ingredients' => [
                [
                    'id' => $recipe->id,
                    'name' => $user->name,
                    'user_id' => $user->id,
                ],
            ]]);
        // レシピが存在しない場合のテスト
        $nonExistingRecipeId = 999;
        $response = $this->json('GET', '/api/recipes/' . $nonExistingRecipeId . '/ingredients');
        $response->assertStatus(404)
            ->assertJson(['message' => 'Recipe not found']);
    }

    public function test_Editメソッドが正しいデータでJsonレスポンスを返す()
    {
        // ジャンルIDが1のデータをデータベースに挿入
        Genre::create(['id' => 1, 'name' => '和食']);
        Category::create(['id' => 1, 'name' => '主菜']);

        // テストユーザーを作成
        $user = User::factory()->create();
        // テストデータの作成
        $dish = Recipe::factory()->create();

        // edit メソッドへのリクエスト
        $response = $this->json('GET', '/api/edit/' . $dish->id);

        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJson(['id' => $dish->id]);
    }

    public function test_Editメソッドが存在しない料理に対して404を返す()
    {
        // 存在しない dishId を指定してリクエスト
        $response = $this->json('GET', '/api/edit/999');

        // レスポンスの検証
        $response->assertStatus(404)
            ->assertJson(['error' => 'Dish not found']);
    }



    public function test_有効なIDでレシピを削除()
    {

        // ジャンルIDが1のデータをデータベースに挿入
        Genre::create(['id' => 1, 'name' => '和食']);
        Category::create(['id' => 1, 'name' => '主菜']);

        // テストユーザーを作成
        $user = User::factory()->create();

        // 新しいレシピを作成してIDを取得
        $newRecipe = Recipe::factory()->create();
        $validId = $newRecipe->id;

        // `destroy`メソッドを呼び出す
        $response = $this->json('DELETE', "/api/delete/{$validId}");

        // レスポンスが期待通りのステータスコードとメッセージを持っていることを検証
        $response->assertStatus(200)
            ->assertJson(['message' => '削除が成功しました']);
    }

    public function test_無効なIDでは削除できない()
    {
        // 存在しないIDを指定したリクエストを作成
        $nonexistentId = 999;

        // `destroy`メソッドを呼び出す
        $response = $this->json('DELETE', "/api/delete/{$nonexistentId}");

        // レスポンスが期待通りのステータスコードとエラーメッセージを持っていることを検証
        $response->assertStatus(500)
            ->assertJson(['error' => '削除が失敗しました']);
    }
}
