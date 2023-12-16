<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuIngredient;
use Carbon\Carbon;
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

    public function getIngredientsListData(Request $request)
    {
        // フロントエンドからのリクエストから日付範囲を取得
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Carbon を使用して日付範囲を解釈
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->addDay()->endOfDay();

        // 指定された日付範囲内のメニューを取得
        $menus = Menu::with('dish.ingredients')->whereBetween('date', [$startDate, $endDate])->get();

        // メニューに紐づく料理と材料を取得
        $menuData = [];

        foreach ($menus as $menu) {
            $dish = $menu->dish;

            if ($dish) {
                $ingredients = $dish->ingredients;

                // 必要な処理を行う（例: 配列にデータをまとめる）
                $menuData[] = [
                    'menu_id' => $menu->id,
                    'date' => $menu->date,
                    'dish_name' => $dish->name,
                    'ingredients' => $ingredients->pluck('name')->toArray(),
                ];
            }
        }

        // JSONレスポンスとしてデータを返す
        return response()->json(['menuData' => $menuData]);
    }
}
