<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;

final class LoginController extends Controller
{
    /**
     * @param AuthManager $auth
     */
    public function __construct(
        private readonly AuthManager $auth,
    ) {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        // リクエストからemailとpasswordの値を取得
        $credentials = $request->only(['email', 'password']);

        // 認証開始
        if ($this->auth->guard()->attempt($credentials)) {
            // セッションIDを再生成
            $request->session()->regenerate();

            // レスポンスを返す
            return new JsonResponse([
                'message' => 'Authenticated.',
            ]);
        }

        // 認証エラーが発生した場合に例外を投げる
        throw new AuthenticationException();
    }
}
