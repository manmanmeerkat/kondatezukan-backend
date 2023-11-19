<?php

use App\Models\Category;
use App\Models\Genre;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GenreControllerTest extends TestCase
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

    public function test_和食のデータを全て取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 1,
            // 他の必要なデータをここに追加する
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->get('/api/japanese'); // エンドポイントの実際のURLに変更する

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_洋食のデータを全て取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 2,
            // 他の必要なデータをここに追加する
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->get('/api/western'); // エンドポイントの実際のURLに変更する

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_中華のデータを全て取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 3,
            // 他の必要なデータをここに追加する
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->get('/api/chinese'); // エンドポイントの実際のURLに変更する

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_その他のデータを全て取得できる()
    {

        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 4,
            // 他の必要なデータをここに追加する
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->get('/api/others'); // エンドポイントの実際のURLに変更する

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の和食のデータを全て取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 1,
            'user_id' => $user->id, // 作成したユーザーに紐づける
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-japanese-recipes");

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の和食・主菜のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 1,
            'category_id' => 1,
            'user_id' => $user->id, // 作成したユーザーに紐づける
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-japanese-syusai");

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の和食・副菜のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 1,
            'category_id' => 2,
            'user_id' => $user->id, // 作成したユーザーに紐づける
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-japanese-fukusai");

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の和食・汁物のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 1,
            'category_id' => 3,
            'user_id' => $user->id, // 作成したユーザーに紐づける
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-japanese-shirumono");

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の和食・その他のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 1,
            'category_id' => 4,
            'user_id' => $user->id, // 作成したユーザーに紐づける
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-japanese-others");

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の洋食のデータを全て取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 2,
            'user_id' => $user->id, // 作成したユーザーに紐づける
        ]);

        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-western-recipes");

        // レスポンスが正常であることを確認
        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の洋食・主菜のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 2,
            'category_id' => 1,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-western-syusai");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の洋食・副菜のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 2,
            'category_id' => 2,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-western-fukusai");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の洋食・汁物のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 2,
            'category_id' => 3,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-western-shirumono");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の洋食・その他のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 2,
            'category_id' => 4,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-western-others");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認
        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の中華のデータを全て取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 3,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-chinese-recipes");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の中華・主菜のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 3,
            'category_id' => 1,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-chinese-syusai");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の中華・副菜のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 3,
            'category_id' => 2,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-chinese-fukusai");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分の中華・汁物のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 3,
            'category_id' => 3,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-chinese-shirumono");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分の中華・その他のデータを全て取得できる()

    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([
            'genre_id' => 3,
            'category_id' => 4,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信
        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-chinese-others");
        // レスポンスが正常であることを確認
        $response->assertStatus(200);
        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [
                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分のその他のデータを全て取得できる()
    {
        // テストユーザーを作成
        $user = User::factory()->create();
        // テスト用のデータを作成する
        Recipe::factory(3)->create([

            'genre_id' => 4,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);
        // テスト用のエンドポイントにリクエストを送信

        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-others-recipes");

        // レスポンスが正常であることを確認

        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [

                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分のその他・主菜のデータを全て取得できる()

    {

        // テストユーザーを作成

        $user = User::factory()->create();

        // テスト用のデータを作成する

        Recipe::factory(3)->create([

            'genre_id' => 4,
            'category_id' => 1,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);

        // テスト用のエンドポイントにリクエストを送信

        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-others-syusai");

        // レスポンスが正常であることを確認

        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [

                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分のその他・副菜のデータを全て取得できる()

    {

        // テストユーザーを作成

        $user = User::factory()->create();

        // テスト用のデータを作成する

        Recipe::factory(3)->create([

            'genre_id' => 4,
            'category_id' => 2,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);

        // テスト用のエンドポイントにリクエストを送信

        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-others-fukusai");

        // レスポンスが正常であることを確認

        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [

                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',

                ]
            ]);
    }

    public function test_自分のその他・汁物のデータを全て取得できる()

    {

        // テストユーザーを作成

        $user = User::factory()->create();

        // テスト用のデータを作成する

        Recipe::factory(3)->create([

            'genre_id' => 4,
            'category_id' => 3,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);

        // テスト用のエンドポイントにリクエストを送信

        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-others-shirumono");

        // レスポンスが正常であることを確認

        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [

                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);
    }

    public function test_自分のその他・その他のデータを全て取得できる()

    {

        // テストユーザーを作成

        $user = User::factory()->create();

        // テスト用のデータを作成する

        Recipe::factory(3)->create([

            'genre_id' => 4,
            'category_id' => 4,
            'user_id' => $user->id, // 作成したユーザーに紐づける

        ]);

        // テスト用のエンドポイントにリクエストを送信

        $response = $this->actingAs($user)->get("/api/user/{$user->id}/all-my-others-others");

        // レスポンスが正常であることを確認

        $response->assertStatus(200);

        // レスポンスが期待通りのデータを含んでいることを確認

        $response->assertJsonCount(3)
            ->assertJsonStructure([

                '*' => [

                    'id',
                    'name',
                    'description',
                    'genre_id',
                    'category_id',
                    'reference_url',
                    'image_path',
                ]
            ]);

        $this->artisan('migrate:refresh');
    }
}
