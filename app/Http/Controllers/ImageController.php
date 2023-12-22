<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        try {
            $imagePath = null;

            if ($request->hasFile('image_file')) {
                $uploadedImage = $request->file('image_file');

                // 画像をリサイズ
                $resizedImage = Image::make($uploadedImage)
                    ->fit(260, 260, function ($constraint) {
                        $constraint->upsize(); // 縦横比を保持
                    });

                // リサイズした画像を保存
                $imagePath = 'uploads/' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();
                Storage::disk('public')->put($imagePath, (string) $resizedImage->encode());
            }

            return response()->json(['image_path' => $imagePath]);
        } catch (\Exception $e) {
            // エラーが発生した場合の処理
            return response()->json(['error' => 'Failed to upload the image'], 500);
        }
    }
}
