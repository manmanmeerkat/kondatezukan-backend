<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();

        Auth::login($user);

        $token = $user->createToken('auth-token', ['expires_in' => 60 * 60])->plainTextToken;
        $userId = $user->id;

        return response()->json([
            'message' => 'ユーザー登録に成功しました',
            'token' => $token,
            'userId' => $userId,
        ], 201);
    }

    // AuthController.php

    public function login(Request $request)
    {
        // ... ログインのバリデーション等

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => '認証に失敗しました'], 401);
        }

        $user = Auth::user();
        $userId = $user->id;
        $role = $user->role;

        // 通常のトークンを生成
        $token = $user->createToken('auth-token', ['expires_in' => 60 * 60])->plainTextToken;

        return response()->json(['message' => 'ユーザーとしてログイン成功', 'userId' => $userId, 'token' => $token, 'role' => $role]);
    }




    public function csrfCookie()
    {
        $csrfToken = csrf_token();
        return response()->json(['csrfToken' => $csrfToken]);
    }

    public function logout(Request $request)
    {
        if ($request->header('X-Csrf-Token') !== csrf_token()) {
            abort(419, 'CSRF トークンが無効です。');
        }

        Auth::logout();

        return response()->json(['message' => 'ログアウトしました']);
    }

    public function showLoginForm()
    {
        return; // または適切なビュー名
    }
}
