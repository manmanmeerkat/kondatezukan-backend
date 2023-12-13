<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuIngredient;
use Illuminate\Support\Facades\Auth;

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

    public function getRecipesForDate($date)
    {
        // ログインしているユーザーのIDを取得
        $userId = Auth::id();

        // 特定の日付に対応するログインしているユーザーのレシピの名前を取得
        $recipes = Menu::where('date', $date)
            ->whereHas('dish', function ($query) use ($userId) {
                $query->where('user_id', 1);
            })
            ->with('dish') // 関連する料理情報も取得
            ->get();

        return response()->json($recipes);
    }

    public function destroy($id)
    {
        try {
            $recipe = Menu::findOrFail($id);
            $recipe->delete();

            return response()->json([], 204); // 成功した場合は204 No Contentを返す
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
