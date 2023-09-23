<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient; // Ingredientモデルをインポート

class IngredientController extends Controller
{
    /**
     * フォームデータを保存するメソッド
     */
    public function store(Request $request)
    {
        // バリデーションルールを設定
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ];

        $request->validate($rules);

        try {
            // フォームデータをデータベースに保存
            $ingredient = new Ingredient();
            $ingredient->name = $request->input('name');
            $ingredient->category = $request->input('category');
            $ingredient->save();

            return response()->json(['message' => 'Ingredient created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save data to the database'], 500);
        }
    }
}
