<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function getUserRecipes($userId)
    {
        // ユーザーを取得
        $user = User::find($userId);

        if ($user) {
            // ユーザーに関連付けられたレシピを取得
            $recipes = $user->recipes;

            return response()->json(['recipes' => $recipes], 200);
        } else {
            return response()->json(['message' => 'ユーザーが見つかりませんでした。'], 404);
        }
    }
}
