<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class DishSearchController extends Controller
{
    public function searchByIngredient(Request $request)
    {
        $ingredient = $request->input('ingredient');

        // 材料からの検索ロジックを実装
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('name', 'like', '%' . $ingredient . '%');
        })->get();

        return response()->json(['recipes' => $recipes]);
    }
}
