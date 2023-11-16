<?php

namespace Tests\Feature;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_japanese_syusai_recipes()
    {
        // テスト用のデータをファクトリを使用して生成
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create([
            'name' => 'ラーメン',
            'genre_id' => 1,
            'category_id' => 1,
            'user_id' => $user->id
        ]);

        // APIエンドポイントを呼び出す
        $response = $this->get('/api/japanese-syusai');

        // レスポンスのアサーション
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // 必要に応じて変更
        $response->assertJsonStructure([
            'data' => [
                // 必要に応じて変更
                '0' => [
                    'id',
                    'name',
                    // 他の属性
                ],
            ],
        ]);

        // データベースから削除
        $recipe->delete();
    }
}
