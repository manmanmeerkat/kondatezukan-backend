<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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


    public function destroySelf(Request $request)
    {
        // ログインしているユーザーを取得
        $user = Auth::user();

        // ユーザーが存在しない場合
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // 'admin' の権限を持つユーザーは削除不可
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Admin user cannot be deleted.'], 403);
        }

        // パスワードが一致するか検証
        $password = $request->input('password');
        if (!$password || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Incorrect password.'], 401);
        }

        // ユーザーを削除
        $user->delete();

        // ログアウト
        Auth::guard('web')->logout();

        return response()->json(['message' => 'User deleted successfully.']);
    }




    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
        ]);

        $user = Auth::user();
        Log::debug($user);
        // 現在のパスワードが正しいか確認
        if (!password_verify($request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages(['current_password' => '現在のパスワードが正しくありません']);
        }

        // 新しいパスワードを設定
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'パスワードが変更されました']);
    }
}

