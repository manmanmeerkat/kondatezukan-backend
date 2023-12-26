<?php

use App\Models\Category;
use App\Models\Dish;
use App\Models\Genre;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

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

    public function test_料理をメニューに追加()
    {
        // テスト用のデータを作成
        $dish = Dish::factory()->create();

        // 正常なリクエスト
        $response = $this->json('POST', 'api/menus', [
            'dish_id' => $dish->id,
            'date' => now()->format('Y-m-d'),
        ]);

        // レスポンスが正常であることを確認
        $response->assertStatus(201);

        // レスポンスのJSONデータを取得
        $responseData = $response->json();

        // データベースにデータが正しく保存されているかを確認
        $this->assertDatabaseHas('menus', [
            'id' => $responseData['id'],
            'dish_id' => $dish->id,
            'date' => now()->format('Y-m-d'),
        ]);

        // 無効なリクエスト（dish_idが存在しない）
        $response = $this->json('POST', 'api/menus', [
            'dish_id' => 999, // 存在しないdish_id
            'date' => now()->format('Y-m-d'),
        ]);

        // レスポンスがエラーであることを確認
        $response->assertStatus(422);

        // エラーレスポンスのJSONデータを取得
        $errorResponse = $response->json();

        // エラーレスポンスに適切なエラーメッセージが含まれているかを確認
        $this->assertArrayHasKey('dish_id', $errorResponse['errors']);
    }

    public function test_指定された日付のユーザーのレシピを取得()
    {
        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // テスト用のメニューデータを作成
        $menu1 = Menu::factory()->create([
            'date' => '2023-12-25',
        ]);

        $menu2 = Menu::factory()->create([
            'date' => '2023-12-25',
        ]);

        // メニューを取得するリクエストを実行
        $response = $this->actingAs($user)->json('GET', 'api/recipes/' . $menu1->date);

        // レスポンスのJSONデータを取得
        $responseData = $response->json();

        // レスポンスのデータが期待通りのものであるかを確認
        $response->assertStatus(200)->assertJson([
            [
                'date' => $menu1->date,
                'id' => $menu1->id,
                'dish' => [
                    'id' => $menu1->dish->id,
                    // 他の dish データの期待値を設定
                ],
                'updated_at' => $menu1->updated_at->toISOString(),
                'created_at' => $menu1->created_at->toISOString(),
                // 他のフィールドの期待値を設定
            ],
            [
                'date' => $menu2->date,
                'id' => $menu2->id,
                'dish' => [
                    'id' => $menu2->dish->id,
                    // 他の dish データの期待値を設定
                ],
                'updated_at' => $menu2->updated_at->toISOString(),
                'created_at' => $menu2->created_at->toISOString(),
                // 他のフィールドの期待値を設定
            ],
            // 他のメニューレコードの期待値を設定
        ]);
    }

    public function test_指定されたIDのレシピを削除()
    {
        // テスト用のメニューデータを作成
        $menu = Menu::factory()->create();

        // メニューを削除するリクエストを実行
        $response = $this->json('DELETE', 'api/delete/menus/' . $menu->id);

        // レスポンスのステータスコードが204 No Contentであることを確認
        $response->assertStatus(204);

        // メニューが削除されたことを確認
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_存在しないIDのレシピを削除()
    {
        // 存在しないIDを指定してメニューを削除するリクエストを実行
        $response = $this->json('DELETE', 'api/delete/menus/999');

        // レスポンスのステータスコードが404 Not Foundであることを確認
        $response->assertStatus(404);

        // エラーメッセージが含まれていることを確認
        $response->assertJson(['error' => 'Not Found']);
    }
}
