<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //genreが"1"でcategoryが"1"のデータを取得
    public function japanese_syusai()
    {
        $japanese_syusai = Recipe::where('genre_id', '1')->where('category_id', '1')->get();
        return response()->json($japanese_syusai);
    }

    //genreが"1"でcategoryが"2"のデータを取得
    public function japanese_fukusai()
    {
        $japanese_fukusai = Recipe::where('genre_id', '1')->where('category_id', '2')->get();
        return response()->json($japanese_fukusai);
    }

    //genre_idが"1"でcategoryが"3"のデータを取得
    public function japanese_shirumono()
    {
        $japanese_shirumono = Recipe::where('genre_id', '1')->where('category_id', '3')->get();
        return response()->json($japanese_shirumono);
    }

    //genre_idが"1"でcategoryが"4"のデータを取得
    public function japanese_others()
    {
        $japanese_others = Recipe::where('genre_id', '1')->where('category_id', '4')->get();
        return response()->json($japanese_others);
    }

    //genre_idが"2"でcategoryが"3"のデータを取得
    public function western_syusai()
    {
        $western_syusai = Recipe::where('genre_id', '2')->where('category_id', '1')->get();
        return response()->json($western_syusai);
    }

    //genre_idが"2"でcategory_idが"2"のデータを取得
    public function western_fukusai()
    {
        $western_fukusai = Recipe::where('genre_id', '2')->where('category_id', '2')->get();
        return response()->json($western_fukusai);
    }

    //genre_idが"2"でcategory_idが"3"のデータを取得
    public function western_shirumono()
    {
        $western_shirumono = Recipe::where('genre_id', '2')->where('category_id', '3')->get();
        return response()->json($western_shirumono);
    }

    //genre_idが"2"でcategoryが"4"のデータを取得
    public function western_others()
    {
        $western_others = Recipe::where('genre_id', '2')->where('category_id', '4')->get();
        return response()->json($western_others);
    }

    //genre_idが"3"でcategory_idが"3"のデータを取得
    public function chinese_syusai()
    {
        $chinese_syusai = Recipe::where('genre_id', '3')->where('category_id', '1')->get();
        return response()->json($chinese_syusai);
    }

    //genre_idが"3"でcategory_idが"2"のデータを取得
    public function chinese_fukusai()
    {
        $chinese_fukusai = Recipe::where('genre_id', '3')->where('category_id', '2')->get();
        return response()->json($chinese_fukusai);
    }

    //genre_idが"3"でcategory_idが"3"のデータを取得
    public function chinese_shirumono()
    {
        $chinese_shirumono = Recipe::where('genre_id', '3')->where('category_id', '3')->get();
        return response()->json($chinese_shirumono);
    }

    //genre_idが"1"でcategoryが"4"のデータを取得
    public function chinese_others()
    {
        $chinese_others = Recipe::where('genre_id', '3')->where('category_id', '4')->get();
        return response()->json($chinese_others);
    }

    //genre_idが"4"でcategory_idが"3"のデータを取得
    public function others_syusai()
    {
        $others_syusai = Recipe::where('genre_id', '4')->where('category_id', '1')->get();
        return response()->json($others_syusai);
    }

    //genre_idが"4"でcategory_idが"2"のデータを取得
    public function others_fukusai()
    {
        $others_fukusai = Recipe::where('genre_id', '4')->where('category_id', '2')->get();
        return response()->json($others_fukusai);
    }

    //genre_idが"4"でcategory_idが"3"のデータを取得
    public function others_shirumono()
    {
        $others_shirumono = Recipe::where('genre_id', '4')->where('category_id', '3')->get();
        return response()->json($others_shirumono);
    }

    //genre_idが"4"でcategory_idが"3"のデータを取得
    public function others_others()
    {
        $others_others = Recipe::where('genre_id', '4')->where('category_id', '4')->get();
        return response()->json($others_others);
    }
}
