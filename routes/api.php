<?php

use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\TypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('menu', MenuController::class);

// Route::get('/random', [RandomController::class, 'random']);

Route::get('/syusai', [RandomController::class, 'syusai']);
Route::get('/fukusai', [RandomController::class, 'fukusai']);
Route::get('/soup', [RandomController::class, 'soup']);

Route::get('/japanese', [GenreController::class, 'japanese']);
Route::get('/western', [GenreController::class, 'western']);
Route::get('/chinese', [GenreController::class, 'chinese']);
Route::get('/others', [GenreController::class, 'others']);

Route::get('/japanese_syusai', [TypeController::class, 'japanese_syusai']);
Route::get('/japanese_fukusai', [TypeController::class, 'japanese_fukusai']);
Route::get('/japanese_soup', [TypeController::class, 'japanese_soup']);
