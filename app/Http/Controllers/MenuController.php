<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Menu;
use App\Models\Recipe;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $recipe = Recipe::all();
        // return response()->json($recipe);

        // ユーザーがログインしているかを確認
        if (Auth::check()) {
            // ログイン中のユーザーのIDを取得
            $userId = Auth::id();

            // ログイン中のユーザーが登録したレシピを取得
            $recipes = Recipe::where('user_id', $userId)->get();

            // レシピが存在しない場合
            if ($recipes->isEmpty()) {
                return response()->json(['message' => 'レシピが見つかりません'], 404);
            }

            return response()->json($recipes);
        } else {
            // ユーザーがログインしていない場合の処理を追加
            return response()->json(['message' => 'ログインしていません'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $menu = Menu::create($request->all());
        // return $menu
        //     ? response()->json($menu, 201)
        //     : response()->json([], 500);


        $menu = new Menu;
        $menu->name = $request->input('name');
        // $menu->memo = $request->input('memo');
        $menu->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $menu = Menu::find($id);

        $menu->name = $request->name;
        // $menu->memo = $request->memo;
        $menu->save();

        return response()->json($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::find($id);
        $menu->delete();
    }





    public function submitform(Request $request)
    {
        // ファイルのアップロード処理
        $imagePath = null;
        if ($request->hasFile('image_file')) {
            try {
                $uploadedImage = $request->file('image_file');

                // 画像をリサイズ
                $resizedImage = Image::make($uploadedImage)
                    ->fit(260, 260, function ($constraint) {
                        $constraint->upsize(); // 縦横比を保持
                    });

                // リサイズした画像を保存
                $imagePath = 'uploads/' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();
                Storage::disk('public')->put($imagePath, (string) $resizedImage->encode());
            } catch (\Exception $e) {
                // ファイルの保存中にエラーが発生した場合の処理
                return response()->json(['error' => 'Failed to upload and resize the image'], 500);
            }
        }

        // トランザクションを開始
        DB::beginTransaction();

        try {
            // レシピの保存
            $recipe = new Recipe();
            $recipe->name = $request->input('name');
            $recipe->description = $request->input('description');
            $recipe->genre_id = $request->input('genre_id');
            $recipe->category_id = $request->input('category_id');
            $recipe->reference_url = $request->input('reference_url');
            $recipe->image_path = $imagePath;
            $recipe->user_id = $request->input('user_id');

            $recipe->save(); // データベースに保存

            // 材料の保存
            // 材料の保存
            $ingredientsData = $request->input('ingredients');

            // $ingredientsData が JSON 文字列でない場合、配列に変換
            if (is_array($ingredientsData)) {
                $ingredientsData = json_encode($ingredientsData);
            }

            $ingredientsData = json_decode($ingredientsData, true);

            if (!is_array($ingredientsData)) {
                $ingredientsData = [];
            }


            foreach ($ingredientsData as $ingredientName) {
                $ingredient = new Ingredient();
                $ingredient->user_id = $request->input('user_id');
                $ingredient->name = $ingredientName;
                $ingredient->save();

                // 中間テーブルに保存
                $recipe->ingredients()->attach($ingredient->id);
            }

            // トランザクションをコミット
            DB::commit();

            return response()->json(['message' => 'Recipe created successfully'], 201);
        } catch (\Exception $e) {
            // Laravelのエラーログにエラーメッセージを記録
            Log::error('Exception: ' . $e->getMessage());
            Log::info('Ingredients from Request:', [$request->input('ingredients')]);

            // トランザクションをロールバック
            DB::rollback();

            return response()->json(['error' => 'Failed to save data to the database'], 500);
        }
    }
}
