<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function japanese_syusai()
    {
        $japanese_syusai = Menu::where('genre', '和食')->where('type', '主菜')->get();
        return response()->json($japanese_syusai);
    }

    public function japanese_fukusai()
    {
        $japanese_fukusai = Menu::where('genre', '和食')->where('type', '副菜')->get();
        return response()->json($japanese_fukusai);
    }

    public function japanese_soup()
    {
        $japanese_soup = Menu::where('genre', '和食')->where('type', '汁物')->get();
        return response()->json($japanese_soup);
    }
}
