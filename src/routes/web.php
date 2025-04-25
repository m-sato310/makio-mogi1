<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show']);

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/register/profile', [RegisterController::class, 'createProfile']);
    Route::post('/register/profile', [RegisterController::class, 'storeProfile']);

    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [MypageController::class, 'editProfile']);
    Route::post('/mypage/profile', [MypageController::class, 'updateProfile']);

    Route::post('/item/{item}/comment', [ItemController::class, 'comment']);
    Route::post('/item/{item}/like', [ItemController::class, 'like']);
    Route::post('/item/{item}/unlike', [ItemController::class, 'unlike']);

    Route::get('/purchase/{item}', [PurchaseController::class, 'create']);
    Route::post('/purchase/{item}', [PurchaseController::class, 'store']);
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editShippingAddress']);
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'storeShippingAddress']);
});