<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Ingredient;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class IngredientTest extends TestCase
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

        User::factory()->create();
    }

    public function test_食材は複数のレシピに所属できること()
    {
        // レシピを作成
        $dish1 = Dish::factory()->create();
        $dish2 = Dish::factory()->create();

        // 食材を作成
        $ingredient = Ingredient::factory()->create();

        // 中間テーブルに dish_id を指定して挿入
        DB::table('ingredient_dish')->insert([
            'ingredient_id' => $ingredient->id,
            'dish_id' => $dish1->id,
        ]);
        DB::table('ingredient_dish')->insert([
            'ingredient_id' => $ingredient->id,
            'dish_id' => $dish2->id,
        ]);

        // 食材を取得し直す
        $ingredient = $ingredient->fresh();

        // 中間テーブル経由でレシピにアクセスできることを確認
        $dishes = $ingredient->dishes;

        // レシピが存在する場合にのみ contains を確認する
        if ($dishes && count($dishes) > 0) {
            $this->assertTrue($dishes->contains($dish1));
            $this->assertTrue($dishes->contains($dish2));
        } else {
            $this->fail('中間テーブル経由でレシピにアクセスできません。');
        }
    }


    public function test_食材のインスタンスが正しく作成されること()
    {
        // レシピを作成
        $dish = Dish::factory()->create();

        // 食材を作成
        $ingredient = Ingredient::factory()->create();

        // 中間テーブルに dish_id を指定して挿入
        DB::table('ingredient_dish')->insert([
            'ingredient_id' => $ingredient->id,
            'dish_id' => $dish->id,
        ]);

        // 食材が正しく作成されていることを確認
        $this->assertDatabaseHas('ingredients', [
            'id' => $ingredient->id,
            'name' => $ingredient->name,
            'user_id' => $ingredient->user_id,
            // 他の必要なフィールドも追加してください
        ]);

        // 中間テーブルのデータが正しく挿入されていることを確認
        $this->assertDatabaseHas('ingredient_dish', [
            'ingredient_id' => $ingredient->id,
            'dish_id' => $dish->id,
        ]);
    }
}
