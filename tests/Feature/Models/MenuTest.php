<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\Dish;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class MenuTest extends TestCase
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

    public function test_create_menu()
    {
        // テスト用のデータを作成
        $dish = Dish::factory()->create();
        $data = [
            'date' => '2023-01-01',
            'dish_id' => $dish->id,
        ];

        // メニューを作成
        $menu = Menu::create($data);

        // 作成されたメニューがデータベースに存在するか確認
        $this->assertDatabaseHas('menus', $data);

        // メニューの属性が正しく設定されているか確認
        $this->assertEquals($data['date'], $menu->date);
        $this->assertEquals($data['dish_id'], $menu->dish_id);
    }

    public function test_update_menu()
    {
        // メニューを作成
        $menu = Menu::factory()->create();

        // 更新するデータ
        $updatedData = [
            'date' => '2023-02-01',
        ];

        // メニューを更新
        $menu->update($updatedData);

        // 更新されたメニューがデータベースに存在するか確認
        $this->assertDatabaseHas('menus', array_merge(['id' => $menu->id], $updatedData));

        // メニューの属性が正しく更新されているか確認
        $this->assertEquals($updatedData['date'], $menu->fresh()->date);
    }

    public function test_delete_menu()
    {
        // メニューを作成
        $menu = Menu::factory()->create();

        // メニューを削除
        $menu->delete();

        // メニューがデータベースから削除されたか確認
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }
}
