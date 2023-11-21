<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
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

    public function test_ユーザーは複数のレシピを持つことができる()
    {
        $user = User::factory()->create();
        $recipe1 = Recipe::factory()->create(['user_id' => $user->id]);
        $recipe2 = Recipe::factory()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->recipes);
        $this->assertInstanceOf(Recipe::class, $user->recipes->first());
    }

    public function test_ユーザーが管理者かどうかを確認できる()
    {
        // $user = User::factory()->create(['role' => 'admin']);
        // $this->assertTrue($user->isAdmin());

        // $user = User::factory()->create(['role' => 'user']);
        // $this->assertFalse($user->isAdmin());
    }
}
