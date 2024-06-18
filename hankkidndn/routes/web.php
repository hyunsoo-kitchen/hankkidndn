<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\MypageController;
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

// 메인 리스트 게시글 획득
Route::get('/api/main', [CommonController::class, 'getList']);

// 각 게시판 정보 획득
Route::get('/api/recipe/{num}', [RecipeBoardController::class, 'getList']);
Route::get('/api/board/{num}', [BoardController::class, 'getList']);

// 회원가입 - 노경호
Route::post('/api/registration', [UserController::class, 'registration']);
// 로그인 - 노경호
Route::post('/api/login', [UserController::class, 'login']);
// 로그아웃 - 노경호
Route::middleware('auth')->post('/api/logout', [UserController::class, 'logout']);


// 마이페이지
Route::put('/api/user', [MypageController::class, 'update']);

//보드 
Route::middleware('auth')->get('/api/board{id}', [BoardController::class, 'boardDeatil']);
Route::middleware('auth')->post('api/boardinsert', [BoardController::class, 'boardInsert']);

// 디테일 게시글 획득
Route::get('/api/detail/{num}', [RecipeBoardController::class, 'getDtail']);