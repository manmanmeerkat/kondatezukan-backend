<?php

use App\Http\Controllers\Admin\Auth\AdminController;
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
use App\Models\Admin;
use App\Http\Middleware\AdminMiddleware;

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


Route::get('/admin/getdish', [AdminController::class, 'adminGetAllDish']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/getuser', [UserController::class, 'getUser']);
    Route::get('/admin/getallusers', [UserController::class, 'getAllUsers']);
});

Route::group(['middleware' => 'cors'], function () {
    Route::post('/submitform', [RecipeController::class, 'create'])->name('create');
});
Route::get('/all-my-dish', [RecipeController::class, 'getUserRecipes']);

Route::get('/edit/{dishId}', [RecipeController::class, 'edit']);

Route::put('/update/{dishId}', [RecipeController::class, 'update'])->middleware('api');

Route::post('/upload-image', [ImageController::class, 'uploadImage']);

Route::delete('/delete/{id}', [RecipeController::class, 'destroy']);

// Route::get('/syusai', [RandomController::class, 'syusai']);
// Route::get('/fukusai', [RandomController::class, 'fukusai']);
// Route::get('/soup', [RandomController::class, 'soup']);

Route::get('/japanese', [GenreController::class, 'japanese']);
Route::get('/western', [GenreController::class, 'western']);
Route::get('/chinese', [GenreController::class, 'chinese']);
Route::get('/others', [GenreController::class, 'others']);

Route::get('/japanese_syusai', [CategoryController::class, 'japanese_syusai']);
Route::get('/japanese_fukusai', [CategoryController::class, 'japanese_fukusai']);
Route::get('/japanese_shirumono', [CategoryController::class, 'japanese_shirumono']);
Route::get('/japanese_others', [CategoryController::class, 'japanese_others']);

Route::get('/western_syusai', [CategoryController::class, 'western_syusai']);
Route::get('/western_fukusai', [CategoryController::class, 'western_fukusai']);
Route::get('/western_shirumono', [CategoryController::class, 'western_shirumono']);
Route::get('/western_others', [CategoryController::class, 'western_others']);

Route::get('/chinese_syusai', [CategoryController::class, 'chinese_syusai']);
Route::get('/chinese_fukusai', [CategoryController::class, 'chinese_fukusai']);
Route::get('/chinese_shirumono', [CategoryController::class, 'chinese_shirumono']);
Route::get('/chinese_others', [CategoryController::class, 'chinese_others']);

Route::get('/others_syusai', [CategoryController::class, 'others_syusai']);
Route::get('/others_fukusai', [CategoryController::class, 'others_fukusai']);
Route::get('/others_shirumono', [CategoryController::class, 'others_shirumono']);
Route::get('/others_others', [CategoryController::class, 'others_others']);



// ログインフォームを表示する
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// ログイン処理を実行する
Route::post('/login', [AuthController::class, 'login'])->middleware('api');
// ログアウト処理を実行する
Route::post('/logout', LogoutController::class)->name('logout');

Route::group(['middleware' => 'api'], function () {
    Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
});


// ユーザー登録フォームを表示する
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// ユーザー登録処理を実行する
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user/{userId}', [UserController::class, 'getUserById']);



Route::get('/csrf-cookie', [AuthController::class, 'csrfCookie'])->middleware('web');


Route::prefix('user/{userId}')->group(function () {
    // Japanese recipes
    Route::get('all-my-japanese-recipes', [GenreController::class, 'getAllMyJapaneseRecipes']);
    Route::get('all-my-japanese-syusai', [GenreController::class, 'getAllMyJapaneseSyusai']);
    Route::get('all-my-japanese-fukusai', [GenreController::class, 'getAllMyJapaneseFukusai']);
    Route::get('all-my-japanese-shirumono', [GenreController::class, 'getAllMyJapaneseShirumono']);
    Route::get('all-my-japanese-others', [GenreController::class, 'getAllMyJapaneseOthers']);

    // Western recipes
    Route::get('all-my-western-recipes', [GenreController::class, 'getAllMyWesternRecipes']);
    Route::get('all-my-western-syusai', [GenreController::class, 'getAllMyWesternSyusai']);
    Route::get('all-my-western-fukusai', [GenreController::class, 'getAllMyWesternFukusai']);
    Route::get('all-my-western-shirumono', [GenreController::class, 'getAllMyWesternShirumono']);
    Route::get('all-my-western-others', [GenreController::class, 'getAllMyWesternOthers']);

    // Chinese recipes
    Route::get('all-my-chinese-recipes', [GenreController::class, 'getAllMyChineseRecipes']);
    Route::get('all-my-chinese-syusai', [GenreController::class, 'getAllMyChineseSyusai']);
    Route::get('all-my-chinese-fukusai', [GenreController::class, 'getAllMyChineseFukusai']);
    Route::get('all-my-chinese-shirumono', [GenreController::class, 'getAllMyChineseShirumono']);
    Route::get('all-my-chinese-others', [GenreController::class, 'getAllMyChineseOthers']);

    // Others recipes
    Route::get('all-my-others-recipes', [GenreController::class, 'getAllMyOthersRecipes']);
    Route::get('all-my-others-syusai', [GenreController::class, 'getAllMyOthersSyusai']);
    Route::get('all-my-others-fukusai', [GenreController::class, 'getAllMyOthersFukusai']);
    Route::get('all-my-others-shirumono', [GenreController::class, 'getAllMyOthersShirumono']);
    Route::get('all-my-others-others', [GenreController::class, 'getAllMyOthersOthers']);
});


Route::get('/recipes/{recipeId}/ingredients', [RecipeController::class, 'getIngredientsForRecipe']);


Route::get('/all-dish/search', [DishSearchController::class, 'searchByIngredient']);

Route::get('/japanese-food/search', [DishSearchController::class, 'searchJapaneseFoodByIngredient']);
Route::get('/western-food/search', [DishSearchController::class, 'searchWesternFoodByIngredient']);
Route::get('/chinese-food/search', [DishSearchController::class, 'searchChineseFoodByIngredient']);
Route::get('/others-food/search', [DishSearchController::class, 'searchOthersFoodByIngredient']);


Route::get('/japanese-syusai/search', [DishSearchController::class, 'searchJapaneseSyusaiByIngredient']);
Route::get('/japanese-fukusai/search', [DishSearchController::class, 'searchJapaneseFukusaiByIngredient']);
Route::get('/japanese-shirumono/search', [DishSearchController::class, 'searchJapaneseShirumonoByIngredient']);
Route::get('/japanese-others/search', [DishSearchController::class, 'searchJapaneseOthersByIngredient']);

Route::get('/western-syusai/search', [DishSearchController::class, 'searchWesternSyusaiByIngredient']);
Route::get('/western-fukusai/search', [DishSearchController::class, 'searchWesternFukusaiByIngredient']);
Route::get('/western-shirumono/search', [DishSearchController::class, 'searchWesternShirumonoByIngredient']);
Route::get('/western-others/search', [DishSearchController::class, 'searchWesternOthersoByIngredient']);

Route::get('/chinese-syusai/search', [DishSearchController::class, 'searchChineseSyusaiByIngredient']);
Route::get('/chinese-fukusai/search', [DishSearchController::class, 'searchChineseFukusaiByIngredient']);
Route::get('/chinese-shirumono/search', [DishSearchController::class, 'searchChineseShirumonoByIngredient']);
Route::get('/chinese-others/search', [DishSearchController::class, 'searchChineseOthersByIngredient']);

Route::get('/others-syusai/search', [DishSearchController::class, 'searchOthersSyusaiByIngredient']);
Route::get('/others-fukusai/search', [DishSearchController::class, 'searchOthersFukusaiByIngredient']);
Route::get('/others-shirumono/search', [DishSearchController::class, 'searchOthersShirumonoByIngredient']);
Route::get('/others-others/search', [DishSearchController::class, 'searchOthersOthersByIngredient']);
