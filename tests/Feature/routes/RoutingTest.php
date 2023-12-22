<?php

use Tests\TestCase;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CategoryController;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RoutingTest extends TestCase
{
    public function test_各ジャンルの料理情報を取得するエンドポイントにアクセスできる()
    {
        $genreRoutes = ['/api/japanese', '/api/western', '/api/chinese', '/api/others'];

        foreach ($genreRoutes as $route) {
            $response = $this->get($route);

            $response->assertStatus(200);
            // ここに各ルートごとの特定のテキストを確認するアサーションを追加

            // 他にも必要なアサーションがあれば追加
        }
    }

    public function test_各ジャンル・カテゴリの料理情報を取得するエンドポイントにアクセスできる()
    {
        $categoryRoutes = [
            '/api/japanese', '/api/western', '/api/chinese', '/api/others',
            '/api/japanese_syusai', '/api/japanese_fukusai', '/api/japanese_shirumono', '/api/japanese_others',
            '/api/western_syusai', '/api/western_fukusai', '/api/western_shirumono', '/api/western_others',
            '/api/chinese_syusai', '/api/chinese_fukusai', '/api/chinese_shirumono', '/api/chinese_others',
            '/api/others_syusai', '/api/others_fukusai', '/api/others_shirumono', '/api/others_others',
        ];

        foreach ($categoryRoutes as $route) {
            $response = $this->get($route);

            $response->assertStatus(200);
        }
    }

    // public function testGetUserByIdEndpoint()
    // {
    //     // Create a user in the database
    //     $user = User::factory()->create();

    //     // Make a GET request to the endpoint
    //     $response = $this->get("/api/user/{$user->id}");
    //     // Assert the response status is 200 OK
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'dishes' => [],
    //         ]);


    //     // Additional assertions as needed
    // }


    public function testDeleteDish()
    {
        // テスト用のレシピをデータベースに作成
        $dish = Dish::factory()->create();



        // レシピを削除するエンドポイントにDELETEリクエストを送信
        $response = $this->delete("/api/delete/{$dish->id}");

        // レスポンスが正常であることを検証
        $response->assertStatus(200);

        // レシピが削除されたことを確認
        $this->assertDatabaseMissing('dishes', ['id' => $dish->id]);
    }

    public function testCsrfCookieEndpoint()
    {
        $response = $this->get('/api/csrf-cookie');

        $response->assertStatus(200)
            ->assertCookie(config('session.cookie'));
    }

    public function testJapaneseDishesRoutes()
    {
        $userId = 1;

        $response = $this->get("/api/user/{$userId}/all-my-japanese-foods");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-japanese-syusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-japanese-fukusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-japanese-shirumono");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-japanese-others");
        $response->assertStatus(200);
    }

    /**
     * Test Western dishes routes
     */
    public function testWesternDishesRoutes()
    {
        $userId = 1;

        $response = $this->get("/api/user/{$userId}/all-my-western-foods");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-western-syusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-western-fukusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-western-shirumono");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-western-others");
        $response->assertStatus(200);
    }

    /**
     * Test Chinese dishes routes
     */
    public function testChineseDishesRoutes()
    {
        $userId = 1;

        $response = $this->get("/api/user/{$userId}/all-my-chinese-foods");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-chinese-syusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-chinese-fukusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-chinese-shirumono");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-chinese-others");
        $response->assertStatus(200);
    }

    /**
     * Test Others dishes routes
     */
    public function testOthersDishesRoutes()
    {
        $userId = 1;

        $response = $this->get("/api/user/{$userId}/all-my-others-foods");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-others-syusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-others-fukusai");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-others-shirumono");
        $response->assertStatus(200);

        $response = $this->get("/api/user/{$userId}/all-my-others-others");
        $response->assertStatus(200);
    }
}
