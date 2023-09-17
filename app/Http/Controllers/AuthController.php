<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // バリデーションを実行
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // ユーザーを作成して保存
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // パスワードのハッシュ化
        ]);
        $user->save();

        // レスポンスを返してユーザー登録の成功を通知
        return response()->json(['message' => 'ユーザー登録に成功しました'], 201);
    }

    public function login(Request $request)
    {
        // バリデーションルールを定義
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            // 認証に失敗した場合
            return response()->json(['message' => '認証に失敗しました'], 401);
        }

        // ユーザーの認証に成功した場合
        $user = Auth::user();
        $userId = $user->id; // ユーザーのuserIdを取得

        // トークンを生成
        $token = $user->createToken('auth-token')->plainTextToken;

        // レスポンスにuserIdも含める
        return response()->json(['message' => 'ログイン成功', 'userId' => $userId, 'token' => $token]);
    }

    public function csrfCookie()
    {
        $csrfToken = csrf_token();
        // CSRFトークンを確認するためのデバッグステートメント
        // dd(['csrfToken' => $csrfToken]);
        return response()->json(['csrfToken' => $csrfToken]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'ログアウトしました']);
    }
}
