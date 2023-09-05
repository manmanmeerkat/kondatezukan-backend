<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class RandomController extends Controller
{
    public function random()
    {
        $menu = Menu::inRandomOrder()->first();
        return response()->json($menu);
    }

    public function soup()
    {
        $soup = Menu::where('type', '汁物')->inRandomOrder()->first();
        return response()->json($soup);
    }
}
