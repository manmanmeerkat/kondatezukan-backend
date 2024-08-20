<?php

use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DishSearchController;
use App\Http\Controllers\MenuController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    // パスワード変更ルート
	Route::post('/change_password', [UserController::class, 'changePassword']);

	Route::get('/all-my-dish', [DishController::class, 'getUserDishes']);

	Route::get('/recipes/{date}', [MenuController::class, 'getRecipesForDate']);

	Route::get('/get-ingredients-list', [MenuController::class, 'getIngredientsListData']);

	Route::post('/relogin', [AuthController::class, 'relogin']);
});

Route::get('/admin/getdish', [AdminController::class, 'adminGetAllDish']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/getuser', [UserController::class, 'getUser']);
    Route::get('/admin/getallusers', [UserController::class, 'getAllUsers']);
});

Route::group(['middleware' => 'cors'], function () {
    Route::post('/create', [DishController::class, 'create'])->name('create');
});

Route::get('/edit/{dishId}', [DishController::class, 'edit']);

Route::put('/update/{dishId}', [DishController::class, 'update'])->middleware('api');

Route::post('/upload-image', [ImageController::class, 'uploadImage']);

Route::delete('/delete/{id}', [DishController::class, 'destroy']);

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
        Route::post('/logout', [LogoutController::class, '__invoke']);

Route::group(['middleware' => 'api'], function () {
    Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
});


// ユーザー登録フォームを表示する
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// ユーザー登録処理を実行する
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user/{userId}', [UserController::class, 'getUserById']);

Route::middleware(['auth:sanctum'])->group(function () {
   // ユーザーが自分自身を削除する
    Route::delete('/users/self', [UserController::class, 'destroySelf']);
});

Route::get('/csrf-cookie', [AuthController::class, 'csrfCookie'])->middleware('web');


Route::prefix('user/{userId}')->group(function () {
    // 和食
    Route::get('all-my-japanese-foods', [GenreController::class, 'getAllMyJapaneseDishes']);
    Route::get('all-my-japanese-syusai', [GenreController::class, 'getAllMyJapaneseSyusai']);
    Route::get('all-my-japanese-fukusai', [GenreController::class, 'getAllMyJapaneseFukusai']);
    Route::get('all-my-japanese-shirumono', [GenreController::class, 'getAllMyJapaneseShirumono']);
    Route::get('all-my-japanese-others', [GenreController::class, 'getAllMyJapaneseOthers']);

    // 洋食
    Route::get('all-my-western-foods', [GenreController::class, 'getAllMyWesternDishes']);
    Route::get('all-my-western-syusai', [GenreController::class, 'getAllMyWesternSyusai']);
    Route::get('all-my-western-fukusai', [GenreController::class, 'getAllMyWesternFukusai']);
    Route::get('all-my-western-shirumono', [GenreController::class, 'getAllMyWesternShirumono']);
    Route::get('all-my-western-others', [GenreController::class, 'getAllMyWesternOthers']);

    // 中華
    Route::get('all-my-chinese-foods', [GenreController::class, 'getAllMyChineseDishes']);
    Route::get('all-my-chinese-syusai', [GenreController::class, 'getAllMyChineseSyusai']);
    Route::get('all-my-chinese-fukusai', [GenreController::class, 'getAllMyChineseFukusai']);
    Route::get('all-my-chinese-shirumono', [GenreController::class, 'getAllMyChineseShirumono']);
    Route::get('all-my-chinese-others', [GenreController::class, 'getAllMyChineseOthers']);

    // その他
    Route::get('all-my-others-foods', [GenreController::class, 'getAllMyOthersDishes']);
    Route::get('all-my-others-syusai', [GenreController::class, 'getAllMyOthersSyusai']);
    Route::get('all-my-others-fukusai', [GenreController::class, 'getAllMyOthersFukusai']);
    Route::get('all-my-others-shirumono', [GenreController::class, 'getAllMyOthersShirumono']);
    Route::get('all-my-others-others', [GenreController::class, 'getAllMyOthersOthers']);
});


Route::get('/dishes/{dishId}/ingredients', [DishController::class, 'getIngredientsForDish']);


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


Route::get('/menus', [MenuController::class, 'index']);
Route::post('/menus', [MenuController::class, 'store']);


Route::delete('/delete/menus/{id}', [MenuController::class, 'destroy']);

Route::post('/menus/{menu}/register-ingredients', [MenuController::class, 'registerMenuIngredients']);


