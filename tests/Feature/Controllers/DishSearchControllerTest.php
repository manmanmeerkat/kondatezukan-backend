<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DishSearchControllerTest extends TestCase
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

    /**
     * 材料からの検索メソッドのテスト
     *
     * @return void
     */
    public function testSearchByIngredient()
    {
        // 仮のデータを作成（適切なものに変更する）
        //     $user = User::factory()->create();

        //     // テスト用のデータ作成部分
        //     $recipe1 = Recipe::factory()->create(['user_id' => $user->id]);
        //     $recipe1->ingredients()->create(['name' => 'Ingredient1', 'user_id' => $user->id]);

        //     $recipe2 = Recipe::factory()->create(['user_id' => $user->id]);
        //     $recipe2->ingredients()->create(['name' => 'Ingredient2', 'user_id' => $user->id]);
        //     // 検索クエリを実行
        //     // 検索クエリを実行
        //     $response = $this->get('/api/all-dish/search', [
        //         // 'ingredient' => 'Ingredient1', // 検索条件（適切なものに変更する）
        //         "user_id" => $user->id,
        //     ]);

        //     // レスポンスが正常であることを確認
        //     $response->assertStatus(200);

        //     // レスポンスの内容を表示

        //     // レスポンスに検索結果が含まれているかどうかを確認
        //     if (count($response->json()['recipes']) > 0) {
        //         $response->assertJson(['recipes' => [$recipe1->toArray()]]);
        //         $response->assertJsonMissing(['recipes' => [$recipe2->toArray()]]);
        //     } else {
        //         // 検索結果がない場合の処理
        //         // ここに何かしらの確認処理を追加するか、コメントで記述しておくと良いでしょう。
        //         dd('検索結果なし');
        //     }
        //     Logger::debug("Search results: " . json_encode($response->json()));
    }
}
