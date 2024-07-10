<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\RecipeBoardController;
use App\Http\Controllers\ReportController;
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
Route::get('/api/board/event/detail/{num}', [BoardController::class, 'event']);

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

// 댓글 갯수 가져오기 
Route::get('/api/board/comment/count/{num}', [CommentController::class, 'getBoardCountComment']);
Route::get('/api/recipe/comment/count/{num}', [CommentController::class, 'getRecipeCountComment']);

// view 증가
Route::post('/api/recipe/detail/view/{num}', [RecipeBoardController::class, 'viewUp']);
Route::post('/api/board/detail/view/{num}', [BoardController::class, 'viewUp']);

// 카카오 로그인 관련
Route::get('/api/login/kakao', [UserController::class, 'redirectToProvider']);
Route::get('/api/login/kakao/callback', [UserController::class, 'handleProviderCallback']);
Route::get('/api/kakaoLogin', [UserController::class, 'kakaoLogin']);

// 신고 기능 관련
Route::post('/api/board/report/{num}', [ReportController::class, 'boardReport']);
Route::post('/api/recipe/report/{num}', [ReportController::class, 'recipeReport']);
Route::post('/api/comment/report/{num}', [ReportController::class, 'commnetReport']);

// 관리자 로그인 관련
Route::post('/api/admin/login', [AdminController::class, 'adminLogin']);
Route::post('/api/admin/logout', [AdminController::class, 'adminLogout']);

// 관리자 공지사항 작성 관련
Route::post('api/admin/notice', [AdminController::class, 'noticeInsert']);

// 공지사항 리스트 획득
Route::get('/api/notice/list', [AdminController::class, 'getList']);
Route::get('/api/board/notice/list', [AdminController::class, 'getBoardNoticeList']);

// 공지사항 상세 정보 획득
Route::get('/api/notice/detail/{num}', [AdminController::class, 'getDetail']);

// 공지사항 수정 처리
Route::get('/api/notice/update/{num}', [AdminController::class, 'getUpdate']);
Route::post('/api/notice/update/{num}', [AdminController::class, 'noticeUpdate']);

// 공지사항 삭제처리
Route::delete('/api/board/notice/delete/{num}', [AdminController::class, 'noticeDelete']);

// 관리자 광고 처리
Route::post('/api/admin/ad', [AdminController::class, 'adInsert']);
Route::get('/api/admin/ad', [AdminController::class, 'getAdData']);

// 관리자 이벤트 처리
Route::get('/api/admin/event', [AdminController::class, 'getEvent']);
Route::post('/api/admin/event', [AdminController::class, 'eventInsert']);

// 신고 상세 페이지
Route::get('/api/recipe/report/detail/{num}', [ReportController::class, 'getRecipeReport']);
Route::get('/api/board/report/detail/{num}', [ReportController::class, 'getBoardReport']);
Route::get('/api/comment/report/detail/{num}', [ReportController::class, 'getCommentReport']);

// 신고 글 승인 처리
Route::post('/api/recipe/approve', [ReportController::class, 'recipeApprove']);
Route::post('/api/board/approve', [ReportController::class, 'boardApprove']);
Route::post('/api/comment/approve', [ReportController::class, 'commentApprove']);

// 신고 글 비승인 처리
Route::post('/api/recipe/reject/{num}', [ReportController::class, 'recipeReject']);
Route::post('/api/board/reject/{num}', [ReportController::class, 'boardReject']);
Route::post('/api/comment/reject/{num}', [ReportController::class, 'commentReject']);

// 유저 제재 기록 조회
Route::get('/api/approve/user/{num}', [ReportController::class, 'getApproveUserInfo']);

//-------------------------끝------------------------------

//---------------------노경호------------------------------

// 회원가입
Route::post('/api/registration', [UserController::class, 'registration']);
// 회원가입 - id체크
Route::post('/api/regist/userid', [UserController::class, 'idCheck']);
// 회원가입 - nickname체크
Route::post('/api/regist/userNickname', [UserController::class, 'nicknameCheck']);
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
// 이현수 탈퇴
Route::delete('/api/user/updateunregister', [UserController::class, 'updateUnregister']);

// 신고받은 레시피 불러오기
Route::get('/api/recipereports', [AdminController::class, 'recipeReportList']);
// 신고받은 게시글 불러오기
Route::get('/api/boardreports', [AdminController::class, 'boardReportList']);
// 신고받은 댓글 불러오기
Route::get('/api/commentreports', [AdminController::class, 'commentReportList']);
// 신고갯수 불러오기
Route::get('api/admin/usersreportinfo', [AdminController::class, 'countReport']);

// 대시보드 신규 가입자 불러오기
Route::get('api/admin/newmembersinfo', [AdminController::class, 'newMemberInfo']);
// 대시보드 일자별 요약 데이터 가져오기
Route::get('api/admin/dailystats', [AdminController::class, 'getDailyStats']);
// 대시보드 주간,월간 요약 데이터 가져오기
Route::get('api/admin/weekstats', [AdminController::class, 'getWeeklyStats']);
Route::get('api/admin/monthstats', [AdminController::class, 'getMonthlyStats']);
// 아직 미처리한 신고갯수 가져오기
Route::get('api/admin/approvechk', [AdminController::class, 'getApproveChkCount']);
// 오늘의 간략 통계 불러오기
Route::get('/api/getDailyStats', [AdminController::class, 'getDailyStats']);
//-----------------------끝--------------------------------
// 마이페이지
// Route::put('/api/user', [MypageController::class, 'update']);

//--------------------------------------------------
// 검색기능 이현수
Route::get('/api/search/recipe', [RecipeBoardController::class, 'search']);
Route::get('/api/search/board/{id}', [BoardController::class, 'search']);
Route::get('/api/search/board/name/{id}', [BoardController::class, 'searchName']);
// ------------------- 끝 -----------------------------

