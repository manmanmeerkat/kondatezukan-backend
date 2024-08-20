<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

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

                // 一意のファイル名を生成 (UUIDを使用)
                $fileName = Str::uuid() . '.' . $uploadedImage->getClientOriginalExtension();

                // S3に画像をアップロード
                $path = 'uploads/' . $fileName;
                Storage::disk('s3')->put($path, (string) $resizedImage->stream());
                $imagePath = Storage::disk('s3')->url($path);
            }

            return response()->json(['image_path' => $imagePath]);
        } catch (\Exception $e) {
            // エラーが発生した場合の処理
            Log::error('Error uploading image: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to upload the image'], 500);
        }
    }
}

