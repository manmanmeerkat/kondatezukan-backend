<?php

// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the menus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ログイン中のユーザーのIDを取得
        $userId = auth()->id();

        // ログイン中のユーザーが作成した献立データを取得
        $menus = Menu::where('user_id', $userId)->get();

        // 取得したデータをJSON形式で返す
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'date' => 'required|date',
        ]);

        $menu = Menu::create([
            'dish_id' => $request->input('dish_id'),
            'date' => $request->input('date'),
        ]);

        return response()->json($menu, 201);
    }
}
