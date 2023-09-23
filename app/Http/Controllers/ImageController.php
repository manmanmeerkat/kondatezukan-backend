<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function uploadImage(Request $request)
    {
        // 画像を保存
        $imagePath = $request->file('image')->store('uploads', 'public');

        return response()->json(['image_path' => $imagePath]);
    }


    public function getImage($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
