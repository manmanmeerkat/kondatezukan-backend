<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RandomController extends Controller
{
    public function random()
    {
        $recipe = Recipe::inRandomOrder()->first();
        return response()->json($recipe);
    }

    public function syusai()
    {
        $syusai = Recipe::where('category', '主菜')->inRandomOrder()->first();
        return response()->json($syusai);
    }

    public function fukusai()
    {
        $fukusai = Recipe::where('category', '副菜')->inRandomOrder()->first();
        return response()->json($fukusai);
    }

    public function soup()
    {
        $soup = Recipe::where('category', '汁物')->inRandomOrder()->first();
        return response()->json($soup);
    }
}
