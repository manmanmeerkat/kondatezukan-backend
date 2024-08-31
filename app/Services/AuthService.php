<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function signin($email, $password)
    {
        // ユーザーをキャッシュから取得またはデータベースから取得
        $user = Cache::remember("user-{$email}", 60, function () use ($email) {
            return User::where('email', $email)->first();
        });

        if (!$user || !Hash::check($password, $user->password)) {
            throw new Exception('認証に失敗しました');
        }

        Auth::login($user);

        $token = $user->createToken('auth-token')->plainTextToken;
        $userId = $user->id;
        $role = $user->role;

        return [
            'userId' => $userId,
            'token' => $token,
            'role' => $role
        ];
    }
}
