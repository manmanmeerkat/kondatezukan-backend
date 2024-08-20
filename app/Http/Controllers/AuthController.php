<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // 既に存在するメールアドレスかどうかを確認
            ],
            'password' => 'required|string|min:8', // パスワードの最小長を 8 文字に変更
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
        // リクエストのバリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ユーザーをキャッシュから取得またはデータベースから取得
        $credentials = $request->only('email', 'password');
        $user = Cache::remember("user-{$credentials['email']}", 60, function () use ($credentials) {
            return User::where('email', $credentials['email'])->first();
        });

        // ユーザーが存在しない、またはパスワードが一致しない場合
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => '認証に失敗しました'], 401);
        }

        // ユーザーが認証された場合
        Auth::login($user);

        // ユーザーのIDとロールを取得
        $userId = $user->id;
        $role = $user->role;

        // 通常のトークンを生成
        $token = $user->createToken('auth-token')->plainTextToken;

        // キャッシュを更新（必要な場合）
        Cache::put("user-{$user->email}", $user, 60);

        return response()->json(['message' => 'ログイン成功', 'userId' => $userId, 'token' => $token, 'role' => $role]);
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

    public function relogin(Request $request)
    {
        // Laravel Sanctumの認証処理を使用してユーザーを認証する
        if ($user = $request->user()) {
            // ログイン成功時の処理
            return response()->json($user);
        } else {
            // ログイン失敗時の処理
            return response()->json(['message' => '再ログインに失敗しました。'], 401);
        }
    }
}
