<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class RecipeController extends Controller
{
    public function getUserRecipes($userId)
    {
        // ユーザーを取得
        $user = User::find($userId);

        if ($user) {
            // ユーザーに関連付けられたレシピを取得
            $recipes = $user->recipes;

            return response()->json(['recipes' => $recipes], 200);
        } else {
            return response()->json(['message' => 'ユーザーが見つかりませんでした。'], 404);
        }
    }

    public function getIngredientsForRecipe($recipeId)
    {
        $recipe = Recipe::find($recipeId);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        $ingredients = $recipe->ingredients;

        return response()->json(['ingredients' => $ingredients], 200);
    }

    public function edit($dishId)
    {
        $dish = Recipe::find($dishId);

        if (!$dish) {
            return response()->json(['error' => 'Dish not found'], 404);
        }

        return response()->json($dish);
    }

    public function update(Request $request, $dishId)
    {
        // トランザクションを開始
        DB::beginTransaction();

        try {
            // メインの料理詳細を更新
            $dish = Recipe::findOrFail($dishId);

            // ログにフォームデータを出力
            Log::info('Form Data:', $request->all());

            // フォームデータをモデルに適用
            $dish->fill($request->except(['ingredients', 'image_file']));

            // ログにデータベースに保存する前の料理情報を出力
            Log::info('Dish Before Update:', $dish->toArray());

            // ジャンルとカテゴリの更新
            $dish->genre()->associate($request->input('genre_id'));
            $dish->category()->associate($request->input('category_id'));
            Log::info('Genre ID from Request:', [$request->input('genre_id')]);

            // ファイルのアップロード処理
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

                    // 更新する料理の画像パスを更新
                    $dish->image_path = $imagePath;
                } catch (\Exception $e) {
                    // ファイルの保存中にエラーが発生した場合の処理
                    Log::error('Exception during image upload: ' . $e->getMessage());
                    return response()->json(['error' => 'Failed to upload and resize the image'], 500);
                }
            }

            $dish->save(); // データベースに保存

            // 材料を更新
            $dish->ingredients()->detach(); // 既存の関連を解除

            $ingredientsParam = $request->input('ingredients', '[]');

            if (is_string($ingredientsParam)) {
                $ingredientsData = json_decode($ingredientsParam, true);
            } else {
                // もしも既に配列が提供されている場合の処理
                $ingredientsData = $ingredientsParam;
            }

            Log::info('Ingredients Input:', [$request->input('ingredients')]);
            foreach ($ingredientsData as $ingredientName) {
                $ingredient = Ingredient::firstOrCreate(
                    ['user_id' => $request->input('user_id'), 'name' => $ingredientName]
                );

                // 中間テーブルに保存
                $dish->ingredients()->attach($ingredient->id);
            }

            // トランザクションをコミット
            DB::commit();

            // ログにデータベースに保存した後の料理情報を出力
            Log::info('Dish After Update:', $dish->toArray());
            Log::info('Ingredients Data:', [$ingredientsData]);

            return response()->json(['message' => 'Update successful'], 200);
        } catch (\Exception $e) {
            // Laravelのエラーログにエラーメッセージを記録
            Log::error('Exception: ' . $e->getMessage());

            // トランザクションをロールバック
            DB::rollback();

            return response()->json(['error' => 'Failed to update data in the database'], 500);
        }
    }
}
