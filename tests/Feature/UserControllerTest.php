<?php


namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase; // テスト用データベースを使用

    public function testGetUserById()
    {
        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // ユーザーのIDを指定してエンドポイントにリクエスト
        $response = $this->get("api/user/{$user->id}");

        // レスポンスのアサート
        $response->assertStatus(200)
            ->assertJsonStructure(['dishes']);
    }

    public function testGetUserByIdNotFound()
    {
        // 存在しないユーザーのIDを指定してエンドポイントにリクエスト
        $response = $this->get("api/user/999");

        // レスポンスのアサート
        $response->assertStatus(404)
            ->assertJson(['message' => 'ユーザーが見つかりませんでした。']);
    }
}
