<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\ImageController;
use App\Models\Recipe;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DishSearchController;

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
// Route::resource('menu', MenuController::class);

// Route::get('/random', [RandomController::class, 'random']);

// Route::post('/submitform', [MenuController::class, 'submitform']);

// Route::middleware(['cors'])->group(function () {
//     Route::post('/submitform', 'MenuController@submitform');
//     // 他のAPIルートも追加できます
// });


Route::group(['middleware' => 'cors'], function () {
    // ここにAPIルートを定義
    Route::post('/submitform', [MenuController::class, 'submitform'])->name('submitform');
    // 他のAPIルートもここに追加
});
Route::get('/all-my-dish', [RecipeController::class, 'getUserRecipes']);

Route::get('/edit/{dishId}', [RecipeController::class, 'edit']);

Route::put('/update/{dishId}', [RecipeController::class, 'update'])->middleware('api');

Route::post('/upload-image', [ImageController::class, 'uploadImage']);

Route::delete('/delete/{id}', [RecipeController::class, 'destroy']);

Route::get('/syusai', [RandomController::class, 'syusai']);
Route::get('/fukusai', [RandomController::class, 'fukusai']);
Route::get('/soup', [RandomController::class, 'soup']);

Route::get('/japanese', [GenreController::class, 'japanese']);
Route::get('/western', [GenreController::class, 'western']);
Route::get('/chinese', [GenreController::class, 'chinese']);
Route::get('/others', [GenreController::class, 'others']);

Route::get('/japanese_syusai', [CategoryController::class, 'japanese_syusai']);
Route::get('/japanese_fukusai', [CategoryController::class, 'japanese_fukusai']);
Route::get('/japanese_shirumono', [CategoryController::class, 'japanese_shirumono']);

Route::get('/western_syusai', [CategoryController::class, 'western_syusai']);
Route::get('/western_fukusai', [CategoryController::class, 'western_fukusai']);
Route::get('/western_shirumono', [CategoryController::class, 'western_shirumono']);

Route::get('/chinese_syusai', [CategoryController::class, 'chinese_syusai']);
Route::get('/chinese_fukusai', [CategoryController::class, 'chinese_fukusai']);
Route::get('/chinese_shirumono', [CategoryController::class, 'chinese_shirumono']);

Route::get('/others_syusai', [CategoryController::class, 'others_syusai']);
Route::get('/others_fukusai', [CategoryController::class, 'others_fukusai']);
Route::get('/others_shirumono', [CategoryController::class, 'others_shirumono']);


// ログインフォームを表示する
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// // ログイン処理を実行する
Route::post('/login', [AuthController::class, 'login'])->middleware('api');
// 
// // ログアウトを実行する
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('api');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('web');




// Route::post('/login', LoginController::class)->name('login'); //追記部分
Route::post('/logout', LogoutController::class)->name('logout'); //追記部分

Route::group(['middleware' => 'api'], function () {
    Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
});


// ユーザー登録フォームを表示する
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// ユーザー登録処理を実行する
Route::post('/register', [AuthController::class, 'register']);

// Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUserData']);

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

Route::get('/recipes/{recipeId}/ingredients', [RecipeController::class, 'getIngredientsForRecipe']);


Route::post('/ingredients', [IngredientController::class, 'store']);

Route::get('/all-dish/search', [DishSearchController::class, 'searchByIngredient']);

Route::get('/japanese-food/search', [DishSearchController::class, 'searchJapaneseFoodByIngredient']);
Route::get('/western-food/search', [DishSearchController::class, 'searchWesternFoodByIngredient']);
Route::get('/chinese-food/search', [DishSearchController::class, 'searchChineseFoodByIngredient']);
// Route::get('/others', [DishSearchController::class, 'searchOtherFoodByIngredient']);

Route::get('/japanese-syusai/search', [DishSearchController::class, 'searchJapaneseSyusaiByIngredient']);
Route::get('/japanese-fukusai/search', [DishSearchController::class, 'searchJapaneseFukusaiByIngredient']);
Route::get('/japanese-shirumono/search', [DishSearchController::class, 'searchJapaneseShirumonoByIngredient']);

Route::get('/western-syusai/search', [DishSearchController::class, 'searchWesternSyusaiByIngredient']);
Route::get('/western-fukusai/search', [DishSearchController::class, 'searchWesternFukusaiByIngredient']);
Route::get('/western-shirumono/search', [DishSearchController::class, 'searchWesternShirumonoByIngredient']);

Route::get('/chinese-syusai/search', [DishSearchController::class, 'searchChineseSyusaiByIngredient']);
Route::get('/chinese-fukusai/search', [DishSearchController::class, 'searchChineseFukusaiByIngredient']);
Route::get('/chinese-shirumono/search', [DishSearchController::class, 'searchChineseShirumonoByIngredient']);
