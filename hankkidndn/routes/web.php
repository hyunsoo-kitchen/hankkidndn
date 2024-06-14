<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\RecipeBoardController;
use App\Http\Controllers\UserController;
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

Route::get('/{any}', function() {
    return view('welcome');
})->where('any', '^(?!api).*$');

Route::get('/api/recipe/list={num}', [RecipeBoardController::class, 'getList']);
Route::get('/api/board/list/{num}', [BoardController::class, 'getList']);

// 회원가입
Route::post('/api/registration', [UserController::class, 'registration']);