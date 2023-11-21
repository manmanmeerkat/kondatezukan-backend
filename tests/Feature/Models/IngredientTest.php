<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Ingredient;
use App\Models\Recipe;
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
        $recipe1 = Recipe::factory()->create();
        $recipe2 = Recipe::factory()->create();

        // 食材を作成
        $ingredient = Ingredient::factory()->create();

        // 中間テーブルに recipe_id を指定して挿入
        DB::table('ingredient_recipe')->insert([
            'ingredient_id' => $ingredient->id,
            'recipe_id' => $recipe1->id,
        ]);
        DB::table('ingredient_recipe')->insert([
            'ingredient_id' => $ingredient->id,
            'recipe_id' => $recipe2->id,
        ]);

        // 食材を取得し直す
        $ingredient = $ingredient->fresh();

        // 中間テーブル経由でレシピにアクセスできることを確認
        $recipes = $ingredient->recipes;

        // レシピが存在する場合にのみ contains を確認する
        if ($recipes && count($recipes) > 0) {
            $this->assertTrue($recipes->contains($recipe1));
            $this->assertTrue($recipes->contains($recipe2));
        } else {
            $this->fail('中間テーブル経由でレシピにアクセスできません。');
        }
    }


    public function test_食材のインスタンスが正しく作成されること()
    {
        // レシピを作成
        $recipe = Recipe::factory()->create();

        // 食材を作成
        $ingredient = Ingredient::factory()->create();

        // 中間テーブルに recipe_id を指定して挿入
        DB::table('ingredient_recipe')->insert([
            'ingredient_id' => $ingredient->id,
            'recipe_id' => $recipe->id,
        ]);

        // 食材が正しく作成されていることを確認
        $this->assertDatabaseHas('ingredients', [
            'id' => $ingredient->id,
            'name' => $ingredient->name,
            'user_id' => $ingredient->user_id,
            // 他の必要なフィールドも追加してください
        ]);

        // 中間テーブルのデータが正しく挿入されていることを確認
        $this->assertDatabaseHas('ingredient_recipe', [
            'ingredient_id' => $ingredient->id,
            'recipe_id' => $recipe->id,
        ]);
    }
}
