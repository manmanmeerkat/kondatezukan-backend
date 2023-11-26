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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseTransactions;

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

    public function test_ユーザーに関連付けられた料理をすべて取得できる()
    {
        // ジャンルIDが1のデータをデータベースに挿入
        Genre::create(['name' => '和食']);
        Category::create(['name' => '主菜']);

        // テストユーザーを作成
        $user = User::factory()->create();

        // 認証済みのユーザーとしてログイン
        Auth::login($user);


        // テスト用のレシピを作成
        $recipe = Recipe::factory(3)->create(['user_id' => $user->id]);

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




    public function test_料理の作成()
    {
        try {
            // ジャンルIDが1のデータをデータベースに挿入
            Genre::create(['id' => 1, 'name' => '和食']);
            Category::create(['id' => 1, 'name' => '主菜']);

            // テストユーザーを作成
            $user = User::factory()->create();

            // 認証済みのユーザーとしてログイン
            Auth::login($user);

            // 画像ファイルを作成
            $image = UploadedFile::fake()->image('test_image.jpg');

            // テスト用のリクエストデータを作成
            $requestData = [
                'user_id' => $user->id,
                'name' => 'Test Dish',
                'genre_id' => 1,
                'category_id' => 1,
                'ingredients' => json_encode(['Ingredient 1', 'Ingredient 2']),
                'image_file' => $image,
                // 他のリクエストデータも追加
            ];

            // テスト用のリクエストを送信
            $response = $this->json('POST', '/api/submitform', $requestData);

            // レスポンスが正常であることを確認
            $response->assertStatus(201);

            // レスポンスの内容を表示
            Log::info($response->content());

            // レスポンスにレシピが含まれていることを確認
            // レスポンスのJSON構造を確認
            $response->assertJson(
                [
                    'message' => 'Recipe created successfully',
                ]
            );

            // データベースにデータが正しく保存されているかを確認
            $recipe = Recipe::where('name', 'Test Dish')->first();

            // recipes テーブルにデータが存在するか確認
            $this->assertDatabaseHas('recipes', [
                'id' => $recipe->id,
                'name' => 'Test Dish',
                'user_id' => $user->id,
                'genre_id' => 1,
                'category_id' => 1,
            ]);

            // recipe_ingredients テーブルにデータが存在するか確認
            $this->assertDatabaseHas('ingredient_recipe', [
                'recipe_id' => $recipe->id,
                // 他の条件も必要に応じて追加
            ]);

            // ストレージに画像が存在するか確認
            $imagePath = 'images/' . $image->hashName();
            $this->assertTrue(
                Storage::disk('public')->exists($imagePath),
                'Image not found at ' . $imagePath
            );
        } catch (\Exception $e) {
            // エラーメッセージをログに残す
            Log::error('作成エラー: ' . $e->getMessage());

            return response()->json(['error' => '作成が失敗しました'], 500);
        }
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

    public function test_料理の更新()
    {
        // テスト用のデータを作成（必要に応じて変更してください）
        $user = User::factory()->create();
        $dish = Recipe::factory()->create(['user_id' => $user->id]);
        $genre = Genre::factory()->create();
        $category = Category::factory()->create();

        // 画像ファイルを作成
        $image = UploadedFile::fake()->image('test_image.jpg');

        // テスト用のリクエストデータを作成
        $requestData = [
            'user_id' => $user->id,
            'genre_id' => $genre->id,
            'category_id' => $category->id,
            'ingredients' => json_encode(['Ingredient 1', 'Ingredient 2']),
            'image_file' => $image,
            // 他のリクエストデータも追加
        ];

        // テスト用のリクエストを送信
        $response = $this->json('PUT', 'api/update/' . $dish->id, $requestData);

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // 再取得
        $dish = Recipe::find($dish->id);

        // 画像のパスが正しく生成されているかを確認
        $this->assertNotNull($dish->image_path);

        // ファイルが存在するかどうかを確認
        $this->assertTrue(Storage::disk('public')->exists($dish->image_path));

        // データベースにデータが正しく保存されているかを確認
        $this->assertDatabaseHas('recipes', [
            'id' => $dish->id,
            'name' => $dish->name,
            'user_id' => $user->id,
            'description' => $dish->description,
            'genre_id' => $genre->id,
            'category_id' => $category->id,
            'image_path' => $dish->image_path,
        ]);
    }
}
