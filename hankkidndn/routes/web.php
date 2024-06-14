<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\RecipeBoardController;
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

// 메인 리스트 게시글 획득
Route::get('/api/main', [CommonController::class, 'getList']);

// 각 게시판 정보 획득
Route::get('/api/recipe/list={num}', [RecipeBoardController::class, 'getList']);
Route::get('/api/board/list={num}', [BoardController::class, 'getList']);