<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CategoryControllerTest extends TestCase
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

    public function test_ジャンルが和食でカテゴリーが主菜のデータを取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 1,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_syusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが和食でカテゴリーが副菜のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 2,
            'image_path' => null,
            'reference_url' => null,
        ]);


        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_fukusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが和食でカテゴリーが汁物のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 3,
            'image_path' => null,
            'reference_url' => null,
        ]);

        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_shirumono');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが和食でカテゴリーがその他のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 1,
            'category_id' => 4,
            'image_path' => null,
            'reference_url' => null,
        ]);

        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/japanese_others');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが洋食でカテゴリーが主菜のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 2,
            'category_id' => 1,
            'image_path' => null,
            'reference_url' => null,
        ]);

        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/western_syusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが洋食でカテゴリーが副菜のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 2,
            'category_id' => 2,
            'image_path' => null,
            'reference_url' => null,
        ]);

        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/western_fukusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが洋食でカテゴリーが汁物のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 2,
            'category_id' => 3,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/western_shirumono');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが洋食でカテゴリーがその他のデータを取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 2,
            'category_id' => 4,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/western_others');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが中華でカテゴリーが主菜のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 3,
            'category_id' => 1,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/chinese_syusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが中華でカテゴリーが副菜のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 3,
            'category_id' => 2,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/chinese_fukusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }
    public function test_ジャンルが中華でカテゴリーが汁物のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 3,
            'category_id' => 3,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/chinese_shirumono');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルが中華でカテゴリーがその他のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 3,
            'category_id' => 4,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/chinese_others');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルがその他でカテゴリーが主菜のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 4,
            'category_id' => 1,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/others_syusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_ジャンルがその他でカテゴリーが副菜のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 4,
            'category_id' => 2,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/others_fukusai');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルがその他でカテゴリーが汁物のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 4,
            'category_id' => 3,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し
        $response = $this->json('GET', '/api/others_shirumono');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);
    }

    public function test_ジャンルがその他でカテゴリーがその他のデータを取得できる()

    {

        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用の複数のデータを作成
        $dishes = Dish::factory()->count(3)->create([
            'user_id' => $user->id,
            'genre_id' => 4,
            'category_id' => 4,
            'image_path' => null,
            'reference_url' => null,
        ]);
        // データ取得エンドポイントを呼び出し

        $response = $this->json('GET', '/api/others_others');
        // レスポンスの検証
        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJson([
                [
                    'id' => $dishes[0]->id,
                    'name' => $dishes[0]->name,
                    'description' => $dishes[0]->description,
                    'genre_id' => $dishes[0]->genre_id,
                    'category_id' => $dishes[0]->category_id,
                    'reference_url' => $dishes[0]->reference_url,
                    'image_path' => $dishes[0]->image_path,
                ]
            ]);

        $this->artisan('migrate:refresh');
    }
}
