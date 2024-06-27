<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\RecipeBoardController;
use App\Http\Controllers\UserController;
use App\Models\RecipeBoards;
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
//---------------------권현수------------------------------

// 네비게이션 가드 - 권현수
Route::get('/api/recipe/route/{num}', [CommonController::class, 'getRecipe']);

// 메인 리스트 게시글 획득 - 권현수
Route::get('/api/main', [CommonController::class, 'getList']);

// 각 게시판 정보 획득 - 권현수
Route::get('/api/recipe/{num}', [RecipeBoardController::class, 'getList']);
Route::get('/api/board/{num}', [BoardController::class, 'getList']);

// 레시피 게시글 작성 처리 - 권현수
Route::middleware('auth')->post('/api/recipe/insert', [RecipeBoardController::class, 'recipeInsert']);

// 레시피 게시글 수정 처리 - 권현수
Route::middleware('auth')->get('/api/recipe/update/{num}', [RecipeBoardController::class, 'getRecipeUpdate']);
Route::middleware('auth')->post('/api/recipe/update/{num}', [RecipeBoardController::class, 'recipeUpdate']);

// 레시피 삭제 처리 - 권현수
Route::delete('/api/recipe/delete/{num}', [RecipeBoardController::class, 'delete']);

// 레시피 게시글 좋아요 처리 - 권현수
Route::put('/api/recipe/like/{num}', [RecipeBoardController::class, 'recipeLike']);

// 레시피 디테일 게시글 획득 - 권현수
Route::get('/api/recipe/detail/{num}', [RecipeBoardController::class, 'getDetail']);

// 레시피 댓글 처리
Route::post('/api/recipe/comment/{num}', [CommentController::class, 'commentRecipeInsert']);

// 보드 디테일 게시글 획득 - 권현수
Route::get('/api/board/detail/{num}', [BoardController::class, 'getDetail']);

// 보드 게시글 삭제 처리 - 권현수
Route::delete('/api/board/delete/{num}', [BoardController::class, 'delete']);

// 보드 게시글 작성 처리 - 권현수
Route::middleware('auth')->post('/api/board/insert', [BoardController::class, 'boardInsert']);

// 보드 게시글 수정 처리 - 권현수
Route::middleware('auth')->get('/api/board/update/{num}', [BoardController::class, 'getBoardUpdate']);
Route::middleware('auth')->post('/api/board/update/{num}', [BoardController::class, 'boardUpdate']);

// 보드 댓글 처리 - 권현수
Route::post('/api/board/comment/{num}', [CommentController::class, 'commentInsert']);
Route::post('/api/board/comment/update/{num}', [CommentController::class, 'commentUpdate']);
Route::delete('/api/board/comment/delete/{num}', [CommentController::class, 'commentDelete']);
Route::put('/api/board/comment/like/{num}', [CommentController::class, 'commentLike']);

// 보드 대댓글 처리 - 권현수
Route::post('/api/board/cocomment/{num}', [CommentController::class, 'cocommentInsert']);



//-------------------------끝------------------------------

//---------------------노경호------------------------------

// 회원가입
Route::post('/api/registration', [UserController::class, 'registration']);
// 로그인
Route::post('/api/login', [UserController::class, 'login']);
// 로그아웃
Route::middleware('auth')->post('/api/logout', [UserController::class, 'logout']);
// 마이페이지 유저정보 획득
Route::middleware('auth')->get('/api/mypage/userinfo', [UserController::class, 'getUserInfo']);
// 마이페이지 유저가 작성한 보드리스트 획득
Route::middleware('auth')->get('/api/mypage/board', [UserController::class, 'getBoardListInMy']);
// 마이페이지 유저가 작성한 레시피 리스트 획득
Route::middleware('auth')->get('/api/mypage/recipe', [UserController::class, 'getRecipeListInMy']);
// 마이페이지 유저가 레시피보드에서 작성한 댓글 리스트 획득
Route::middleware('auth')->get('/api/mypage/rcomment', [UserController::class, 'getRecieCommentList']);
// 마이페이지 유저가 게시판보드에서 작성한 댓글 리스트 획득
Route::middleware('auth')->get('/api/mypage/bcomment', [UserController::class, 'getBoardCommentList']);

// 마이페이지에서 개인정보 인증
Route::post('/api/authenticate', [UserController::class, 'authenticate']);

// 비밀번호 수정
Route::post('/api/user/updatepassword', [UserController::class, 'updatePassword']);
// 닉네임변경
Route::post('/api/user/updatenickname', [UserController::class, 'updateNickname']);
// 휴대폰번호 수정
Route::post('/api/user/updatephonenum', [UserController::class, 'updatePhonenum']);
// 프로필사진 등록
Route::post('/api/profile/update', [UserController::class, 'updateProfile']);
// 생년월일 수정
Route::post('/api/user/updatebirthat', [UserController::class, 'updateBirthat']);
// 주소 수정
Route::post('/api/user/updateaddress', [UserController::class, 'updateAddress']);


//-----------------------끝--------------------------------
// 마이페이지
// Route::put('/api/user', [MypageController::class, 'update']);

//--------------------------------------------------
// 보드디테일 조회수기능 이현수
Route::get('/api/search/recipe', [RecipeBoardController::class, 'search']);
Route::get('/api/search/board/{id}', [BoardController::class, 'search']);
Route::get('/api/search/board/name/{id}', [BoardController::class, 'searchName']);
// ------------------- 끝 -----------------------------

