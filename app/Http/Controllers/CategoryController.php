<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //genreが"和食"でtypeが"汁物"のデータを取得
    public function japanese_syusai()
    {
        $japanese_syusai = Recipe::where('genre', '和食')->where('category', '主菜')->get();
        return response()->json($japanese_syusai);
    }

    //genreが"和食"でcategoryが"副菜"のデータを取得
    public function japanese_fukusai()
    {
        $japanese_fukusai = Recipe::where('genre', '和食')->where('category', '副菜')->get();
        return response()->json($japanese_fukusai);
    }

    //genreが"和食"でcategoryが"汁物"のデータを取得
    public function japanese_soup()
    {
        $japanese_soup = Recipe::where('genre', '和食')->where('category', '汁物')->get();
        return response()->json($japanese_soup);
    }

    //genreが"洋食"でcategoryが"汁物"のデータを取得
    public function western_syusai()
    {
        $western_syusai = Recipe::where('genre', '洋食')->where('category', '主菜')->get();
        return response()->json($western_syusai);
    }

    //genreが"洋食"でcategoryが"副菜"のデータを取得
    public function western_fukusai()
    {
        $western_fukusai = Recipe::where('genre', '洋食')->where('category', '副菜')->get();
        return response()->json($western_fukusai);
    }

    //genreが"洋食"でcategoryが"汁物"のデータを取得
    public function western_soup()
    {
        $western_soup = Recipe::where('genre', '洋食')->where('category', '汁物')->get();
        return response()->json($western_soup);
    }

    //genreが"中華"でcategoryが"汁物"のデータを取得
    public function chinese_syusai()
    {
        $chinese_syusai = Recipe::where('genre', '中華')->where('category', '主菜')->get();
        return response()->json($chinese_syusai);
    }

    //genreが"中華"でcategoryが"副菜"のデータを取得
    public function chinese_fukusai()
    {
        $chinese_fukusai = Recipe::where('genre', '中華')->where('category', '副菜')->get();
        return response()->json($chinese_fukusai);
    }

    //genreが"中華"でcategoryが"汁物"のデータを取得
    public function chinese_soup()
    {
        $chinese_soup = Recipe::where('genre', '中華')->where('category', '汁物')->get();
        return response()->json($chinese_soup);
    }

    //genreが"その他"でcategoryが"汁物"のデータを取得
    public function others_syusai()
    {
        $others_syusai = Recipe::where('genre', 'その他')->where('category', '主菜')->get();
        return response()->json($others_syusai);
    }

    //genreが"その他"でcategoryが"副菜"のデータを取得
    public function others_fukusai()
    {
        $others_fukusai = Recipe::where('genre', 'その他')->where('category', '副菜')->get();
        return response()->json($others_fukusai);
    }

    //genreが"その他"でcategoryが"汁物"のデータを取得
    public function others_soup()
    {
        $others_soup = Recipe::where('genre', 'その他')->where('category', '汁物')->get();
        return response()->json($others_soup);
    }
}
