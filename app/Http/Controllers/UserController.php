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
            $dishes = $user->dishes;

            return response()->json(['dishes' => $dishes], 200);
        } else {
            return response()->json(['message' => 'ユーザーが見つかりませんでした。'], 404);
        }
    }

    public function getUser(Request $request)
    {
        $user = $request->user(); // ユーザー情報を取得
        // ユーザー情報が正しく取得できているか確認
        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    public function getAllUsers()
    {
        // すべてのユーザーデータを取得
        $users = User::all();

        return response()->json(['users' => $users]);
    }
}
