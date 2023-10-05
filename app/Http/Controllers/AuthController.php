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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => '認証に失敗しました'], 401);
        }

        $user = Auth::user();
        $userId = $user->id;

        $token = $user->createToken('auth-token', ['expires_in' => 60 * 60])->plainTextToken;

        return response()->json(['message' => 'ログイン成功', 'userId' => $userId, 'token' => $token]);
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
}
