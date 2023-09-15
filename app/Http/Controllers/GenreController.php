<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function japanese()
    {
        $japanese = Recipe::where('genre', '和食')->get();
        return response()->json($japanese);
    }

    public function western()
    {
        $western = Recipe::where('genre', '洋食')->get();
        return response()->json($western);
    }

    public function chinese()
    {
        $chinese = Recipe::where('genre', '中華')->get();
        return response()->json($chinese);
    }

    public function others()
    {
        $others = Recipe::where('genre', 'その他')->get();
        return response()->json($others);
    }
}
