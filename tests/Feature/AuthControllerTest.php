<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザー登録が成功すること()
    {
        $userData = [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // ユーザー登録のAPIエンドポイントを呼び出す
        $response = $this->postJson('/api/register', $userData);

        // レスポンスが正常であることを確認
        $response->assertStatus(201);

        // データベースにユーザーが保存されていることを確認
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);

        // レスポンスにトークンとユーザーIDが含まれていることを確認
        $response->assertJsonStructure([
            'message',
            'token',
            'userId',
        ]);
    }

    public function test_ログインが成功すること()
    {
        // テスト用のユーザーを作成
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // ログインのAPIエンドポイントを呼び出す
        $response = $this->postJson('/api/login', $credentials);

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスにトークン、ユーザーID、および役割が含まれていることを確認
        $response->assertJsonStructure([
            'message',
            'userId',
            'token',
            'role',
        ]);

        // データベースにトークンが保存されていることを確認
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'auth-token',
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
        ]);

        // 認証されていることを確認
        $this->assertTrue(Auth::check());
    }

    public function test_ログインが失敗すること()
    {
        $credentials = [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ];

        // ログインのAPIエンドポイントを呼び出す
        $response = $this->postJson('/api/login', $credentials);

        // レスポンスが認証エラーであることを確認
        $response->assertStatus(401);

        // レスポンスにエラーメッセージが含まれていることを確認
        $response->assertJson(['message' => '認証に失敗しました']);

        // 認証されていないことを確認
        $this->assertFalse(Auth::check());
    }

    public function test_CSRFトークンが正しく返されること()
    {
        // CSRFトークンを取得するためにAPIエンドポイントを呼び出す
        $response = $this->getJson('/api/csrf-cookie');

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスにCSRFトークンが含まれていることを確認
        $response->assertJsonStructure([
            'csrfToken',
        ]);

        // レスポンスのCSRFトークンと、クライアントが取得したCSRFトークンが一致することを確認
        $this->assertEquals(csrf_token(), $response->json('csrfToken'));
    }

    public function test_ログアウトが成功すること()
    {
        // テスト用のユーザーを作成してログイン
        $user = User::factory()->create();
        Auth::login($user);

        // ログアウトのAPIエンドポイントを呼び出す
        $response = $this->postJson('/api/logout', [], ['X-Csrf-Token' => csrf_token()]);

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // Laravel 8以降では 'Unauthenticated' というメッセージが期待される
        $response->assertJson(['message' => 'Unauthenticated.']);

        // ユーザーがログアウトしていることを確認
        $this->assertFalse(Auth::check());
    }


    public function test_CSRFトークンが無効な場合にログアウトが中断されること()
    {
        // テスト用のユーザーを作成してログイン
        $user = User::factory()->create();
        Auth::login($user);

        // ログアウトのAPIエンドポイントを呼び出す
        $response = $this->postJson('/api/logout', [], ['X-Csrf-Token' => 'invalid-token']);

        // レスポンスが正常であることを確認
        $response->assertStatus(419);

        // レスポンスにエラーメッセージが含まれていることを確認
        $response->assertJson(['message' => 'CSRF トークンが無効です。']);

        // ユーザーがログアウトしていないことを確認
        $this->assertTrue(Auth::check());
    }
}
