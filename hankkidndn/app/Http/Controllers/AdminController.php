<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAutheException;
use App\Models\Admin;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // 어드민 로그인
    public function adminLogin(Request $request) {
        // 유저 정보 획득
        $adminInfo = Admin::where('admin_id', $request->admin_id)
                    ->first();

        // 유저 정보 오류
        if(!isset($adminInfo)) {
            // 유저 없음
            throw new MyAutheException('E20');
        } else if(!(Hash::check($request->admin_password, $adminInfo->admin_password))) {
            // 비밀번호 오류
            throw new MyAutheException('E21');
        }

        Log::debug('확인완료');
        // 로그인 처리
        Auth::login($adminInfo);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '로그인 성공'
            ,'data' => $adminInfo
        ];

        return response() -> json($responseData, 200)->cookie('admin', '1', 120, null, null, false, false);
    }

    //어드민 로그아웃
    public function adminLogout() {
        Auth::logout();
        Session::invalidate(); // 기본 세션 파기하고 새로운 세션 생성
        Session::regenerateToken(); // CSRF 토큰 재발급

        $responseData = [
            'code' => '0'
            ,'msg' => '로그아웃 완료'
        ];
        return response()
                ->json($responseData, 200)
                ->cookie('admin', '1', -1,
                
                
                null, null, false, false);
    }

    // 노경호 ----------------------------------------------------------------------------------------------
    //신고데이터 조회(레시피)
    // public function recipeReportList() {
    //     $reportData = Report::join('report_type', 'reports.report_type_id', '=', 'report_type.id' )
    //                         ->select(
    //                             'reports.*',
    //                             'report_type.report_name'
    //                         )
    //                         ->whereNotNull('recipe_board_id')
    //                         ->orderBy('reporst.created_at', 'DESC')
    //                         ->paginate(10);
        
    //     $responseData = [
    //         'code' => '0',
    //         'msg' => '댓글 및 레시피 제목 획득 완료',
    //         'data' => $reportData->toArray()
    //     ];

    //     return response()->json($responseData, 200);
    // }
    public function recipeReportList() {
        $reportData = DB::table('reports')
                    ->join('recipe_boards', 'reports.recipe_board_id', '=', 'recipe_boards.id')
                    ->join('users as report_users', 'recipe_boards.user_id', '=', 'report_users.id')
                    ->join('users as report_author', 'reports.user_id', '=', 'report_author.id')
                    ->join('report_types', 'reports.report_type_id', '=', 'report_types.id')
                    ->select(
                        // 'reports.*',
                        'recipe_boards.title as recipe_title',
                        'report_users.u_nickname as recipe_author',
                        DB::raw('(SELECT COUNT(reports.recipe_board_id) FROM reports WHERE reports.recipe_board_id = recipe_boards.id GROUP BY reports.recipe_board_id) as report_count'),
                        'report_author.u_nickname as reporter_nickname',
                        'reports.content as report_reason',
                        'reports.created_at as report_time'
                    )
                    ->whereNotNull('reports.recipe_board_id')
                    ->groupBy('reports.id', 'recipe_boards.title', 'report_users.u_nickname', 'report_author.u_nickname', 'reports.content', 'reports.created_at', 'report_types.report_name')
                    ->orderBy('reports.created_at', 'DESC')
                    ->paginate(10);

        $reportDataArray = $reportData->items();

        $responseData = [
                    'code' => '0',
                    'msg' => '리폿 리스트 획득 완료',
                    'data' => $reportDataArray
                ];
        
        return response()->json($responseData, 200);
    }
    //------------------------------------------------------------------------------------------------------
}
