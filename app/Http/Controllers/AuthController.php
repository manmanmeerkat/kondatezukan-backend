<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            $result = $this->authService->signin($credentials['email'], $credentials['password']);

            $userId = $result['userId'] ?? null;
            $token = $result['token'] ?? null;
            $role = $result['role'] ?? null;

            if ($userId === null || $token === null || $role === null) {
                return response()->json(['message' => 'Login failed'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }

        return response()->json([
            'message' => 'ログインしました',
            'userId' => $userId,
            'token' => $token,
            'role' => $role
        ]);
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
        return;
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
