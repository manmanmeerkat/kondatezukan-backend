<?php

use Tests\TestCase;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CategoryController;

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
            // ここに各ルートごとの特定のテキストを確認するアサーションを追加

            // 他にも必要なアサーションがあれば追加
        }
    }
}
