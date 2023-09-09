<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    //genreが"和食"でtypeが"汁物"のデータを取得
    public function japanese_syusai()
    {
        $japanese_syusai = Menu::where('genre', '和食')->where('type', '主菜')->get();
        return response()->json($japanese_syusai);
    }

    //genreが"和食"でtypeが"副菜"のデータを取得
    public function japanese_fukusai()
    {
        $japanese_fukusai = Menu::where('genre', '和食')->where('type', '副菜')->get();
        return response()->json($japanese_fukusai);
    }

    //genreが"和食"でtypeが"汁物"のデータを取得
    public function japanese_soup()
    {
        $japanese_soup = Menu::where('genre', '和食')->where('type', '汁物')->get();
        return response()->json($japanese_soup);
    }

    //genreが"洋食"でtypeが"汁物"のデータを取得
    public function western_syusai()
    {
        $western_syusai = Menu::where('genre', '洋食')->where('type', '主菜')->get();
        return response()->json($western_syusai);
    }

    //genreが"洋食"でtypeが"副菜"のデータを取得
    public function western_fukusai()
    {
        $western_fukusai = Menu::where('genre', '洋食')->where('type', '副菜')->get();
        return response()->json($western_fukusai);
    }

    //genreが"洋食"でtypeが"汁物"のデータを取得
    public function western_soup()
    {
        $western_soup = Menu::where('genre', '洋食')->where('type', '汁物')->get();
        return response()->json($western_soup);
    }

    //genreが"中華"でtypeが"汁物"のデータを取得
    public function chinese_syusai()
    {
        $chinese_syusai = Menu::where('genre', '中華')->where('type', '主菜')->get();
        return response()->json($chinese_syusai);
    }

    //genreが"中華"でtypeが"副菜"のデータを取得
    public function chinese_fukusai()
    {
        $chinese_fukusai = Menu::where('genre', '中華')->where('type', '副菜')->get();
        return response()->json($chinese_fukusai);
    }

    //genreが"中華"でtypeが"汁物"のデータを取得
    public function chinese_soup()
    {
        $chinese_soup = Menu::where('genre', '中華')->where('type', '汁物')->get();
        return response()->json($chinese_soup);
    }

    //genreが"その他"でtypeが"汁物"のデータを取得
    public function others_syusai()
    {
        $others_syusai = Menu::where('genre', 'その他')->where('type', '主菜')->get();
        return response()->json($others_syusai);
    }

    //genreが"その他"でtypeが"副菜"のデータを取得
    public function others_fukusai()
    {
        $others_fukusai = Menu::where('genre', 'その他')->where('type', '副菜')->get();
        return response()->json($others_fukusai);
    }

    //genreが"その他"でtypeが"汁物"のデータを取得
    public function others_soup()
    {
        $others_soup = Menu::where('genre', 'その他')->where('type', '汁物')->get();
        return response()->json($others_soup);
    }
}
