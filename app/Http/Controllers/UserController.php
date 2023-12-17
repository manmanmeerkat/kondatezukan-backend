<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function destroySelf()
    {
        // ログインしているユーザーのIDを取得
        $userId = Auth::id();

        // ユーザーが存在しない場合
        if (!$userId) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // 'admin' の権限を持つユーザーは削除不可
        $user = User::find($userId);
        if ($user && $user->role === 'admin') {
            return response()->json(['message' => 'Admin user cannot be deleted.'], 403);
        }

        // ユーザーを削除
        if ($user) {
            $user->delete();

            // ログアウト
            Auth::logout();

            return response()->json(['message' => 'User deleted successfully.']);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }
}
