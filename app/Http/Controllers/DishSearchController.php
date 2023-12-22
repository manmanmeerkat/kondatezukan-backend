<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishSearchController extends Controller
{
    public function searchByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        logger("Search request received. Ingredient: $ingredient, User ID: $user_id");

        // 材料からの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('user_id', $user_id)->get();

        logger($dishes);

        return response()->json(['dishes' => $dishes]);
    }

    public function searchJapaneseFoodByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンルからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 1)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchJapaneseSyusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 1)->where('category_id', 1)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchJapaneseFukusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 1)->where('category_id', 2)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchJapaneseShirumonoByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 1)->where('category_id', 3)->where('user_id', $user_id)->get();
        return response()->json(['dishes' => $dishes]);
    }

    public function searchJapaneseOthersByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 1)->where('category_id', 4)->where('user_id', $user_id)->get();
        return response()->json(['dishes' => $dishes]);
    }

    public function searchWesternFoodByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンルからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 2)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchWesternSyusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 2)->where('category_id', 1)->where('user_id', $user_id)->get();

        // user_idが指定されている場合、それに一致するもののみを取得


        return response()->json(['dishes' => $dishes]);
    }


    public function searchWesternFukusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 2)->where('category_id', 2)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchWesternShirumonoByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 2)->where('category_id', 3)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchWesternOthersByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 2)->where('category_id', 4)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchChineseFoodByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 3)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchChineseSyusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 3)->where('category_id', 1)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchChineseFukusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 3)->where('category_id', 2)->where('user_id', $user_id)->get();
        return response()->json(['dishes' => $dishes]);
    }

    public function searchChineseShirumonoByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 3)->where('category_id', 3)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchChineseOthersByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 3)->where('category_id', 4)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }
    public function searchOthersFoodByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 4)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchOthersSyusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 4)->where('category_id', 1)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchOthersFukusaiByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 4)->where('category_id', 2)->where('user_id', $user_id)->get();
        return response()->json(['dishes' => $dishes]);
    }

    public function searchOthersShirumonoByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 4)->where('category_id', 3)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }

    public function searchOthersOthersByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');
        $user_id = $request->input('user_id');

        // 材料とジャンル、カテゴリーからの検索ロジックを実装
        $dishes = Dish::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->where('genre_id', 4)->where('category_id', 4)->where('user_id', $user_id)->get();

        return response()->json(['dishes' => $dishes]);
    }
}
