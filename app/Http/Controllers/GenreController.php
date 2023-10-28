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
        try {
            $japaneseRecipes = Recipe::where('genre_id', 1)
                ->get();

            return response()->json($japaneseRecipes);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching Japanese recipes.'], 500);
        }
    }

    public function western()
    {
        $western = Recipe::where('genre_id', '2')->get();
        return response()->json($western);
    }

    public function chinese()
    {
        $chinese = Recipe::where('genre_id', '3')->get();
        return response()->json($chinese);
    }

    public function others()
    {
        $others = Recipe::where('genre_id', '4')->get();
        return response()->json($others);
    }

    public function getAllMyJapaneseRecipes($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseRecipes = Recipe::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($japaneseRecipes);
    }

    public function getAllMyJapaneseSyusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseSyusai = Recipe::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 1)
            ->get();

        return response()->json($japaneseSyusai);
    }

    public function getAllMyJapaneseFukusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseFukusai = Recipe::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($japaneseFukusai);
    }

    public function getAllMyJapaneseShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseShirumono = Recipe::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($japaneseShirumono);
    }

    public function getAllMyJapaneseOthers($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseOthers = Recipe::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($japaneseOthers);
    }



    public function getAllMyWesternRecipes($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $allMyWesternRecipes = Recipe::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyWesternRecipes);
    }

    public function getAllMyWesternSyusai($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernSyusai = Recipe::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 1)
            ->get();

        return response()->json($westernSyusai);
    }

    public function getAllMyWesternFukusai($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernFukusai = Recipe::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($westernFukusai);
    }

    public function getAllMyWesternShirumono($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernShirumono = Recipe::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($westernShirumono);
    }

    public function getAllMyWesternOthers($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernOthers = Recipe::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($westernOthers);
    }

    public function getAllMyChineseRecipes($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $allMyChineseRecipes = Recipe::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyChineseRecipes);
    }

    public function getAllMyChineseSyusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $chineseSyusai = Recipe::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', '1')
            ->get();

        return response()->json($chineseSyusai);
    }

    public function getAllMyChineseFukusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $chineseFukusai = Recipe::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($chineseFukusai);
    }

    public function getAllMyChineseShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseShirumono = Recipe::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($chineseShirumono);
    }

    public function getAllMyChineseOthers($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseOthers = Recipe::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($chineseOthers);
    }

    public function getAllMyOthersRecipes($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $allMyOthersRecipes = Recipe::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyOthersRecipes);
    }

    public function getAllMyOthersSyusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $othersSyusai = Recipe::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', '1')
            ->get();

        return response()->json($othersSyusai);
    }

    public function getAllMyOthersFukusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $othersFukusai = Recipe::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($othersFukusai);
    }

    public function getAllMyOthersShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $othersShirumono = Recipe::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($othersShirumono);
    }

    public function getAllMyOthersOthers($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $othersOthers = Recipe::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($othersOthers);
    }
}
