<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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

Route::post('/submitform', [MenuController::class, 'submitform']);

Route::get('/syusai', [RandomController::class, 'syusai']);
Route::get('/fukusai', [RandomController::class, 'fukusai']);
Route::get('/soup', [RandomController::class, 'soup']);

Route::get('/japanese', [GenreController::class, 'japanese']);
Route::get('/western', [GenreController::class, 'western']);
Route::get('/chinese', [GenreController::class, 'chinese']);
Route::get('/others', [GenreController::class, 'others']);

Route::get('/japanese_syusai', [CategoryController::class, 'japanese_syusai']);
Route::get('/japanese_fukusai', [CategoryController::class, 'japanese_fukusai']);
Route::get('/japanese_soup', [CategoryController::class, 'japanese_soup']);

Route::get('/western_syusai', [CategoryController::class, 'western_syusai']);
Route::get('/western_fukusai', [CategoryController::class, 'western_fukusai']);
Route::get('/western_soup', [CategoryController::class, 'western_soup']);

Route::get('/chinese_syusai', [CategoryController::class, 'chinese_syusai']);
Route::get('/chinese_fukusai', [CategoryController::class, 'chinese_fukusai']);
Route::get('/chinese_soup', [CategoryController::class, 'chinese_soup']);

Route::get('/others_syusai', [CategoryController::class, 'others_syusai']);
Route::get('/others_fukusai', [CategoryController::class, 'others_fukusai']);
Route::get('/others_soup', [CategoryController::class, 'others_soup']);


// ログインフォームを表示する
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// ログイン処理を実行する
Route::post('/login', [AuthController::class, 'login'])->middleware('api');

// ログアウトを実行する
// Route::get('/logout', [AuthController::class, 'logout'])->middleware('api');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('web');


// ユーザー登録フォームを表示する
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// ユーザー登録処理を実行する
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUserData']);

Route::get('/user/{userId}', [UserController::class, 'getUserById']);


Route::get('/csrf-cookie', [AuthController::class, 'csrfCookie'])->middleware('web');


Route::get('user/{userId}/all-my-japanese-recipes', [GenreController::class, 'getAllMyJapaneseRecipes']);

Route::get('user/{userId}/all-my-japanese-syusai', [GenreController::class, 'getAllMyJapaneseSyusai']);

Route::get('user/{userId}/all-my-japanese-fukusai', [GenreController::class, 'getAllMyJapaneseFukusai']);

Route::get('user/{userId}/all-my-japanese-shirumono', [GenreController::class, 'getAllMyJapaneseShirumono']);




Route::get('user/{userId}/all-my-western-recipes', [GenreController::class, 'getAllMyWesternRecipes']);

Route::get('user/{userId}/all-my-western-syusai', [GenreController::class, 'getAllMyWesternSyusai']);

Route::get('user/{userId}/all-my-western-fukusai', [GenreController::class, 'getAllMyWesternFukusai']);

Route::get('user/{userId}/all-my-western-shirumono', [GenreController::class, 'getAllMyWesternShirumono']);


Route::get('user/{userId}/all-my-chinese-recipes', [GenreController::class, 'getAllMyChineseRecipes']);

Route::get('user/{userId}/all-my-chinese-syusai', [GenreController::class, 'getAllMyChineseSyusai']);

Route::get('user/{userId}/all-my-chinese-fukusai', [GenreController::class, 'getAllMyChineseFukusai']);

Route::get('user/{userId}/all-my-chinese-shirumono', [GenreController::class, 'getAllMyChineseShirumono']);
