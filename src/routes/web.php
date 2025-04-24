<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
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

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/mypage/profile', [ProfileController::class, 'edit']);
Route::post('/mypage/profile', [ProfileController::class, 'update']);

Route::post('/login', [LoginController::class, 'store']);

Route::get('/item/{item}', [ItemController::class, 'show']);
Route::post('/item/{item}/comment', [ItemController::class, 'comment'])->middleware('auth');
Route::post('/item/{item}/like', [ItemController::class, 'like'])->middleware('auth');
Route::post('/item/{item}/unlike', [ItemController::class, 'unlike'])->middleware('auth');

Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->middleware('auth');
Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->middleware('auth');