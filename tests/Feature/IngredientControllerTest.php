<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class IngredientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_レシピを登録したと同時に材料テーブルに材料のフォームデータを保存できること()
    {
        // モックを追加してログを表示できるようにする
        Log::shouldReceive('info')->passthru();

        // テストユーザーを作成
        $user = User::factory()->create();

        // 認証済みのユーザーとしてログイン
        $this->actingAs($user);

        // テスト用のフォームデータ
        $data = [
            'name' => 'テスト食材',
            'category' => 'テストカテゴリ',
        ];

        // レシピ登録エンドポイントを呼び出し
        $response = $this->post('/api/ingredients', $data);

        // レスポンスが正常であることを確認
        $response->assertStatus(Response::HTTP_CREATED);

        // レスポンスの内容をログに出力
        Log::info($response->status());
        Log::info($response->content());

        // レスポンスに期待されるJSONデータが含まれていることを確認
        $response->assertJson([
            'name' => $data['name'],
            'category' => $data['category'],
        ]);

        // データベースにデータが保存されていることを確認
        $this->assertDatabaseHas('ingredients', [
            'name' => $data['name'],
            'category' => $data['category'],
        ]);
    }



    public function test_バリデーションエラーが発生すること()
    {
        // バリデーションエラーを引き起こすデータ
        $data = [
            'name' => '', // 空の名前
            'category' => 'テストカテゴリ',
        ];

        // フォームデータをPOSTリクエストで送信
        $response = $this->postJson('/api/ingredients', $data);

        // レスポンスがバリデーションエラーとなることを確認
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // エラーメッセージが含まれていることを確認
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_データベースエラーが発生すること()
    {
        // モデルのモックを修正
        $this->mock(Ingredient::class, function ($mock) {
            $mock->shouldReceive('save')->andReturn(false); // データベースエラーを引き起こすように修正
        });

        $data = [
            'name' => 'テスト食材',
            'category' => 'テストカテゴリ',
        ];

        // レスポンスがデータベースエラーとなることを確認
        $response = $this->postJson('/api/ingredients', $data);
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

        // エラーメッセージが含まれていることを確認
        $response->assertJson(['error' => 'Failed to save data to the database']);
    }
}
