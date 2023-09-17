<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenreController extends Controller
{
    public function japanese()
    {
        $japanese = Recipe::where('genre', '和食')->get();
        return response()->json($japanese);
    }

    public function western()
    {
        $western = Recipe::where('genre', '洋食')->get();
        return response()->json($western);
    }

    public function chinese()
    {
        $chinese = Recipe::where('genre', '中華')->get();
        return response()->json($chinese);
    }

    public function others()
    {
        $others = Recipe::where('genre', 'その他')->get();
        return response()->json($others);
    }

    public function getAllMyJapaneseRecipes($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseRecipes = Recipe::where('genre', '和食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($japaneseRecipes);
    }

    public function getAllMyJapaneseSyusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseRecipes = Recipe::where('genre', '和食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '主菜')
            ->get();

        return response()->json($japaneseRecipes);
    }

    public function getAllMyJapaneseFukusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseRecipes = Recipe::where('genre', '和食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '副菜')
            ->get();
        return response()->json($japaneseRecipes);
    }

    public function getAllMyJapaneseShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseRecipes = Recipe::where('genre', '和食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '汁物')
            ->get();
        return response()->json($japaneseRecipes);
    }



    public function getAllMyWesternRecipes($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $allMyWesternRecipes = Recipe::where('genre', '洋食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyWesternRecipes);
    }

    public function getAllMyWesternSyusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $westernRecipes = Recipe::where('genre', '洋食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '主菜')
            ->get();

        return response()->json($westernRecipes);
    }

    public function getAllMyWesternFukusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $westernRecipes = Recipe::where('genre', '洋食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '副菜')
            ->get();
        return response()->json($westernRecipes);
    }

    public function getAllMyWesternShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $westernRecipes = Recipe::where('genre', '洋食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '汁物')
            ->get();
        return response()->json($westernRecipes);
    }

    public function getAllMyChineseRecipes($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $allMyChineseRecipes = Recipe::where('genre', '中華')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyChineseRecipes);
    }

    public function getAllMyChineseSyusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseRecipes = Recipe::where('genre', '洋食')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '主菜')
            ->get();

        return response()->json($chineseRecipes);
    }

    public function getAllMyChineseFukusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseRecipes = Recipe::where('genre', '中華')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '副菜')
            ->get();
        return response()->json($chineseRecipes);
    }

    public function getAllMyChineseShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseRecipes = Recipe::where('genre', '中華')
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category', '汁物')
            ->get();
        return response()->json($chineseRecipes);
    }
}
