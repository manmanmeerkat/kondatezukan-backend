<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserById($userId)
    {
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
