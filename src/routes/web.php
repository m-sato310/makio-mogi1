<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
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
// ↓これは仮のルート
Route::get('/', function () {
    return view('items.index');
});

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/mypage/profile', [ProfileController::class, 'edit']);
Route::post('/mypage/profile', [ProfileController::class, 'update']);

Route::post('/login', [LoginController::class, 'store']);
