<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    // public function adminLogin(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();

    //         // ユーザーが管理者ロールを持っているかを確認
    //         if ($user->hasRole('admin') && Hash::check($request->password, $user->password)) {
    //             // ログインしたユーザーに新しいトークンを作成
    //             $token = $user->createToken('admin-token')->plainTextToken;

    //             return response()->json(['token' => $token]);
    //         }
    //     }

    //     return response()->json(['error' => 'Unauthorized'], 401);
    // }
}
