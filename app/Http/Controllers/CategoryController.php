<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dish;

class CategoryController extends Controller
{
    //ジャンルが"和食"でカテゴリが"主食"のデータを取得
    public function japanese_syusai()
    {
        $japanese_syusai = Dish::where('genre_id', '1')->where('category_id', '1')->get();
        return response()->json($japanese_syusai);
    }

    //ジャンルが"和食"でカテゴリが"副菜"のデータを取得
    public function japanese_fukusai()
    {
        $japanese_fukusai = Dish::where('genre_id', '1')->where('category_id', '2')->get();
        return response()->json($japanese_fukusai);
    }

    //ジャンルが"和食"でカテゴリが"汁物"のデータを取得
    public function japanese_shirumono()
    {
        $japanese_shirumono = Dish::where('genre_id', '1')->where('category_id', '3')->get();
        return response()->json($japanese_shirumono);
    }

    //ジャンルが"和食"でカテゴリが"その他"のデータを取得
    public function japanese_others()
    {
        $japanese_others = Dish::where('genre_id', '1')->where('category_id', '4')->get();
        return response()->json($japanese_others);
    }

    //ジャンルが"洋食"でカテゴリが"主食"のデータを取得
    public function western_syusai()
    {
        $western_syusai = Dish::where('genre_id', '2')->where('category_id', '1')->get();
        return response()->json($western_syusai);
    }

    //ジャンルが"洋食"でカテゴリが"汁物"のデータを取得
    public function western_fukusai()
    {
        $western_fukusai = Dish::where('genre_id', '2')->where('category_id', '2')->get();
        return response()->json($western_fukusai);
    }

    //ジャンルが"洋食"でカテゴリが"汁物"のデータを取得
    public function western_shirumono()
    {
        $western_shirumono = Dish::where('genre_id', '2')->where('category_id', '3')->get();
        return response()->json($western_shirumono);
    }

    //ジャンルが"洋食"でカテゴリが"その他"のデータを取得
    public function western_others()
    {
        $western_others = Dish::where('genre_id', '2')->where('category_id', '4')->get();
        return response()->json($western_others);
    }

    //ジャンルが"中華"でカテゴリが"主菜"のデータを取得
    public function chinese_syusai()
    {
        $chinese_syusai = Dish::where('genre_id', '3')->where('category_id', '1')->get();
        return response()->json($chinese_syusai);
    }

    //ジャンルが"中華"でカテゴリが"副菜"のデータを取得
    public function chinese_fukusai()
    {
        $chinese_fukusai = Dish::where('genre_id', '3')->where('category_id', '2')->get();
        return response()->json($chinese_fukusai);
    }

    //ジャンルが"中華"でカテゴリが"汁物"のデータを取得
    public function chinese_shirumono()
    {
        $chinese_shirumono = Dish::where('genre_id', '3')->where('category_id', '3')->get();
        return response()->json($chinese_shirumono);
    }

    //ジャンルが"中華"でカテゴリが"その他"のデータを取得
    public function chinese_others()
    {
        $chinese_others = Dish::where('genre_id', '3')->where('category_id', '4')->get();
        return response()->json($chinese_others);
    }

    //ジャンルが"その他"でカテゴリが"主菜"のデータを取得
    public function others_syusai()
    {
        $others_syusai = Dish::where('genre_id', '4')->where('category_id', '1')->get();
        return response()->json($others_syusai);
    }

    //ジャンルが"その他"でカテゴリが"副菜"のデータを取得
    public function others_fukusai()
    {
        $others_fukusai = Dish::where('genre_id', '4')->where('category_id', '2')->get();
        return response()->json($others_fukusai);
    }

    //ジャンルが"その他"でカテゴリが"汁物"のデータを取得
    public function others_shirumono()
    {
        $others_shirumono = Dish::where('genre_id', '4')->where('category_id', '3')->get();
        return response()->json($others_shirumono);
    }

    //ジャンルが"その他"でカテゴリが"その他"のデータを取得
    public function others_others()
    {
        $others_others = Dish::where('genre_id', '4')->where('category_id', '4')->get();
        return response()->json($others_others);
    }
}
