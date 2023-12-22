<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dish;

class GenreController extends Controller
{
    public function japanese()
    {
        try {
            $japanese = Dish::where('genre_id', 1)
                ->get();

            return response()->json($japanese);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching Japanese dishes.'], 500);
        }
    }

    public function western()
    {
        $western = Dish::where('genre_id', '2')->get();
        return response()->json($western);
    }

    public function chinese()
    {
        $chinese = Dish::where('genre_id', '3')->get();
        return response()->json($chinese);
    }

    public function others()
    {
        $others = Dish::where('genre_id', '4')->get();
        return response()->json($others);
    }

    public function getAllMyJapaneseDishes($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseDishes = Dish::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($japaneseDishes);
    }

    public function getAllMyJapaneseSyusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseSyusai = Dish::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 1)
            ->get();

        return response()->json($japaneseSyusai);
    }

    public function getAllMyJapaneseFukusai($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseFukusai = Dish::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($japaneseFukusai);
    }

    public function getAllMyJapaneseShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseShirumono = Dish::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($japaneseShirumono);
    }

    public function getAllMyJapaneseOthers($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $japaneseOthers = Dish::where('genre_id', 1)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($japaneseOthers);
    }



    public function getAllMyWesternDishes($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $allMyWesternDishes = Dish::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyWesternDishes);
    }

    public function getAllMyWesternSyusai($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernSyusai = Dish::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 1)
            ->get();

        return response()->json($westernSyusai);
    }

    public function getAllMyWesternFukusai($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernFukusai = Dish::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($westernFukusai);
    }

    public function getAllMyWesternShirumono($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernShirumono = Dish::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($westernShirumono);
    }

    public function getAllMyWesternOthers($userId)
    {
        // ユーザーIDを使用して洋食のレシピ情報を取得
        $westernOthers = Dish::where('genre_id', 2)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($westernOthers);
    }

    public function getAllMyChineseDishes($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $allMyChineseDishes = Dish::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyChineseDishes);
    }

    public function getAllMyChineseSyusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $chineseSyusai = Dish::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', '1')
            ->get();

        return response()->json($chineseSyusai);
    }

    public function getAllMyChineseFukusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $chineseFukusai = Dish::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($chineseFukusai);
    }

    public function getAllMyChineseShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseShirumono = Dish::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($chineseShirumono);
    }

    public function getAllMyChineseOthers($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $chineseOthers = Dish::where('genre_id', 3)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($chineseOthers);
    }

    public function getAllMyOthersDishes($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $allMyOthersDishes = Dish::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->get();

        return response()->json($allMyOthersDishes);
    }

    public function getAllMyOthersSyusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $othersSyusai = Dish::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', '1')
            ->get();

        return response()->json($othersSyusai);
    }

    public function getAllMyOthersFukusai($userId)
    {
        // ユーザーIDを使用して中華のレシピ情報を取得
        $othersFukusai = Dish::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 2)
            ->get();
        return response()->json($othersFukusai);
    }

    public function getAllMyOthersShirumono($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $othersShirumono = Dish::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 3)
            ->get();
        return response()->json($othersShirumono);
    }

    public function getAllMyOthersOthers($userId)
    {
        // ユーザーIDを使用して和食のレシピ情報を取得
        $othersOthers = Dish::where('genre_id', 4)
            ->where('user_id', $userId) // ユーザーIDでフィルタリング
            ->where('category_id', 4)
            ->get();
        return response()->json($othersOthers);
    }
}
