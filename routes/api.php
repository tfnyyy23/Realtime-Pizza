<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ChartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public route
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/categories', [MenuCategoryController::class, 'index']);
Route::get('/categories/{id}', [MenuCategoryController::class, 'show']);
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);

//protected route
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/categories/{id}', [MenuCategoryController::class, 'store']);
    Route::post('/menus/{id}', [MenuController::class, 'store']);
    Route::put('/categories/{id}/{id_user}', [MenuCategoryController::class, 'update']);
    Route::delete('/categories/{id}/{id_user}', [MenuCategoryController::class, 'destroy']);
    Route::post('/menus/{id}', [MenuController::class, 'store']);
    Route::get('/search_menu/{name_menu}', [MenuController::class, 'searchmenu']);
    Route::put('/menus/{id}/{id_user}', [MenuController::class, 'update']);
    Route::delete('/menus/{id}/{id_user}', [MenuController::class, 'destroy']);
    Route::post('/cart/{id_menu}', [ChartController::class, 'store']);
    Route::get('/cart/{id_user}', [ChartController::class, 'show']);
    Route::put('/cart/{id}/{id_user}', [ChartController::class, 'update']);
    Route::delete('/cart/{id}/{id_user}', [ChartController::class, 'destroy']);
});

Route::resource('categories', MenuCategoryController::class)->except([
    'store','create', 'edit'
]);
Route::resource('menus', MenuController::class)->except([
    'create', 'edit'
]);
