<?php

namespace Tests\Feature;

use App\Models\Category;
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


    private $genres;
    private $categories;

    public function setUp(): void
    {
        parent::setUp();

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

    public function test_ジャンルが和食でカテゴリーが主菜のレシピを取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();


        // 認証済みのユーザーとしてログイン
        Auth::login($user);

        // テスト用の複数のレシピを作成
        $recipes = Recipe::factory()->count(1)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 1,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // レシピ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_syusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => $recipes[0]->id,
                    'name' => $recipes[0]->name,
                    'description' => $recipes[0]->description,
                    'genre_id' => $recipes[0]->genre_id,
                    'category_id' => $recipes[0]->category_id,
                    'reference_url' => $recipes[0]->reference_url,
                    'image_path' => $recipes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが和食でカテゴリーが副菜のレシピを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();


        dd($this->categories);
        // 認証済みのユーザーとしてログイン
        Auth::login($user);
        // テスト用の複数のレシピを作成
        $recipes = Recipe::factory()->count(1)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 2,
            'image_path' => null,
            'reference_url' => null,
        ]);


        // レシピ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_fukusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => $recipes[0]->id,
                    'name' => $recipes[0]->name,
                    'description' => $recipes[0]->description,
                    'genre_id' => $recipes[0]->genre_id,
                    'category_id' => $recipes[0]->category_id,
                    'reference_url' => $recipes[0]->reference_url,
                    'image_path' => $recipes[0]->image_path,
                ]
            ]);
    }
}
