<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class DishController extends Controller
{
    public function getUserDishes()
    {
        // 認証済みのユーザーを取得
        $user = Auth::user();

        if (!$user) {
            // 認証されていない場合の処理
            return response()->json(['message' => 'ユーザーが認証されていません。'], 401);
        }

        // ユーザーに関連付けられた料理を取得
        $dishes = Dish::where('user_id', $user->id)->get();

        return response()->json(['dishes' => $dishes], 200);
    }


    public function getIngredientsForDish($dishId)
    {
        $dish = Dish::find($dishId);

        if (!$dish) {
            return response()->json(['message' => 'Dish not found'], 404);
        }

        $ingredients = $dish->ingredients;

        Log::info('Ingredients for dish ' . $dishId . ':', $ingredients->toArray());

        return response()->json(['ingredients' => $ingredients], 200);
    }

    public function edit($dishId)
    {
        $dish = Dish::find($dishId);

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
            $dish = Dish::findOrFail($dishId);

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

            foreach ($ingredientsData as $ingredientData) {
                $ingredientName = $ingredientData['name'];
                $ingredientQuantity = $ingredientData['quantity'];

                // 材料を検索または作成
                $ingredient = Ingredient::firstOrCreate(
                    ['user_id' => $request->input('user_id'), 'name' => $ingredientName, 'quantity' => $ingredientQuantity]
                );

                // 中間テーブルに保存（数量も含めて保存）
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

    public function destroy($id)
    {
        try {
            // 料理を取得
            $dish = Dish::findOrFail($id);

            // 関連する材料も削除
            $dish->ingredients()->detach();

            // 料理を削除
            $dish->delete();

            return response()->json(['message' => '削除が成功しました'], 200);
        } catch (\Exception $e) {
            // エラーメッセージをログに残す
            Log::error('削除エラー: ' . $e->getMessage());

            return response()->json(['error' => '削除が失敗しました'], 500);
        }
    }

    public function create(Request $request)
    {
        // トランザクションを開始
        DB::beginTransaction();

        try {
            // 料理の保存
            $dish = new Dish();
            $dish->name = $request->input('name');
            $dish->description = $request->input('description');
            $dish->genre_id = $request->input('genre_id');
            $dish->category_id = $request->input('category_id');
            $dish->reference_url = $request->input('reference_url');
            $dish->image_path = $request->input('image_path');
            $dish->user_id = $request->input('user_id');
            $dish->save(); // データベースに保存

            // 材料の保存
            $ingredientsData = $request->input('ingredients');

            // $ingredientsData が JSON 文字列でない場合、配列に変換
            if (!is_array($ingredientsData)) {
                $ingredientsData = json_decode($ingredientsData, true);
            }

            // $ingredientsData が JSON デコードできない場合、空の配列に設定
            if (!is_array($ingredientsData)) {
                $ingredientsData = [];
            }

            foreach ($ingredientsData as $ingredientData) {
                $ingredient = new Ingredient();
                $ingredient->user_id = $request->input('user_id');
                $ingredient->name = $ingredientData['name'];
                $ingredient->quantity = $ingredientData['quantity'];
                $ingredient->save();

                // 中間テーブルに保存
                $dish->ingredients()->attach($ingredient->id);
            }

            // トランザクションをコミット
            DB::commit();

            return response()->json(['message' => 'Dish created successfully'], 201);
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
