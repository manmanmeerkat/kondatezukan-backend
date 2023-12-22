<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CsrfCookieControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * CSRFトークンのクッキーが返されることをテストします。
     *
     * @return void
     */
    public function test_csrf_token_cookie_is_returned()
    {
        // CsrfCookieControllerのshowメソッドにGETリクエストを送信
        $response = $this->get('/api/csrf-cookie');

        // レスポンスが正常であることを確認
        $response->assertStatus(Response::HTTP_OK);

        // レスポンスのJSONデータに'csrfToken'が含まれていることを確認
        $response->assertJsonStructure(['csrfToken']);

        // レスポンスのクッキーにCSRFトークンが含まれていることを確認
        $response->assertCookie('XSRF-TOKEN');
    }
}
