<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class CanManageUsers
{
    public function handle($request, Closure $next)
    {
        // ユーザーがログインしており、かつ manage-users 権限を持っている場合
        if (auth()->check() && $this->userHasPermission(auth()->user(), 'manage-users')) {
            return $next($request);
        }

        // 権限がない場合は 403 エラーを返す
        throw new AuthorizationException('This action is unauthorized.', 403);
    }

    protected function userHasPermission($user, $permission)
    {
        // UserPolicy の manageUsers メソッドを呼び出して権限を確認する
        return app(\App\Policies\UserPolicy::class)->manageUsers($user);
    }
}
