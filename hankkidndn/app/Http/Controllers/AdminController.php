<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAutheException;
use App\Exceptions\MyValidateException;
use App\Models\adImg;
use App\Models\Admin;
use App\Models\Boards;
use App\Models\Event;
use App\Models\notice;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // --------------------------------------------권현수---------------------------------------------------
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

    // 공지사항 작성
    public function noticeInsert(Request $request) {
        $user = Auth::user();

        $request['admin_id'] = $user->id;

        $requestData = $request->all();
        
        $validator = Validator::make(
            $requestData
            ,[
                'admin_id' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:1000']
                ,'title' => ['required', 'max:100']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $insertData = [
            'title' => $request->title,
            'content' => $request->content,
            'admin_id' => $user->id
        ];

        $noticeData = Notice::create($insertData);

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $noticeData
        ];

        return response()->json($responseData, 200);
    }

    // 공지사항 리스트 획득
    public function getList() {
        $noticeData = Notice::join('admins', 'admins.id', '=', 'notices.admin_id')
                    ->select('notices.*', 'admins.admin_name')
                    ->orderBy('notices.created_at', 'DESC')
                    ->paginate(10);

        $responseData = [
        'code' => '0'
        ,'msg' => '게시글 획득 완료'
        ,'data' => $noticeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 보드 공지사항 리스트 획득
    public function getBoardNoticeList() {
        $noticeData = Notice::join('admins', 'admins.id', '=', 'notices.admin_id')
                    ->select('notices.*', 'admins.admin_name')
                    ->orderBy('notices.created_at', 'DESC')
                    ->paginate(10);

        $responseData = [
        'code' => '0'
        ,'msg' => '게시글 획득 완료'
        ,'data' => $noticeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function getDetail($id) {
        // 보드 정보 획득
        $noticeData = Notice::join('admins', 'admins.id', '=', 'notices.admin_id')
                    ->select('notices.*', 'admins.admin_name')
                    ->where('notices.id', '=', $id)
                    ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $noticeData
        ];


        return response()->json($responseData, 200);
    }

    // 보드 게시글 수정처리
    public function noticeUpdate(Request $request) {

        $requestData = $request->all();

        $validator = Validator::make(
            $requestData
            ,[
                'content' => ['required', 'max:1000']
                ,'title' => ['required', 'max:100']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }
        
        $insertData = [
            'title' => $request->title,
            'content' => $request->content,
        ];
        
        $noticeId = $request->num;

        $noticeData = Notice::find($noticeId);

        $noticeData->update($insertData);

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $noticeData
        ];

        return response()->json($responseData, 200);
    }

    // 공지 수정 정보 획득
    public function getUpdate($id) {
        // 보드 정보 획득
        $noticeData = Notice::join('admins', 'admins.id', '=', 'notices.admin_id')
                    ->select('notices.*', 'admins.admin_name')
                    ->where('notices.id', '=', $id)
                    ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $noticeData
        ];


        return response()->json($responseData, 200);
    }

    // 공지 삭제 처리
    public function noticeDelete($id) {
        
        Notice::destroy($id);

        $responseData = [
            'code' => '0'
            ,'msg' => '글 삭제 완료'
            ,'data' => $id
        ];

        return response()->json($responseData);
    }

    // 광고 획득 처리
    public function getAdData() {
        $adData = adImg::get();

        $responseData = [
            'code' => '0'
            ,'msg' => '광고 획득 완료'
            ,'data' => $adData
        ];

        return response()->json($responseData, 200);
    }

    // 광고 작성 처리
    public function adInsert(Request $request) {
        $user = Auth::user();

        AdImg::query()->delete();
    
        $updateData = json_decode($request->ad);

        foreach($updateData as $key => $item) {

            $adData = new adImg();
            $adData->admin_id = $user->id;
            $adData->img_path = $item->img_path;

            // 프로그램 내용 및 파일 업로드 유효성 검사
            // $validator = Validator::make(
            //     [
            //         'file' => $request->file('file' . ($key + 1)),
            //     ],
            //     [
            //         'file' => 'image|mimes:jpeg,jpg,png',
            //     ]
            // );

            // // 유효성 검사 실패 체크
            // if ($validator->fails()) {
            //     Log::debug('파일 업로드 유효성 검사 실패', $validator->errors()->toArray());
            //     throw new MyValidateException('E01');
            // }

            if($request->has('file'.($key + 1))) {

                $imgPath = $request->file('file'.($key + 1))->store('img');

                $adData->img_path = '/'.$imgPath;
            }

            $adData->save();
        }
        

        $responseData = [
            'code' => '0'
            ,'msg' => '광고 삽입 완료'
        ];

        return response()->json($responseData, 200);
    }

    public function getEvent() {
        $nowDate = now();

        $progressEvent = Event::where('end_date', '>=', $nowDate)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        $finishEvent = Event::where('end_date', '<', $nowDate)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        $responseData = [
            'code' => '0'
            ,'msg' => '광고 삽입 완료'
            ,'progressData' => $progressEvent
            ,'finishData' => $finishEvent
        ];

        return response()->json($responseData, 200);
    }

    public function eventInsert(Request $request) {
        $user = Auth::user();
        $request['admin_id'] = $user->id;

        $requestData = $request->all();
        
        $validator = Validator::make(
            $requestData
            ,[
                'admin_id' => ['required', 'regex:/^[0-9]+$/']
                ,'title' => ['required', 'max:50']
                ,'start_at' => ['required', 'date']
                ,'end_at' => ['required', 'date', 'after:start_at']
                ,'thumbnail' => ['required', 'mimes:jpeg,png', 'max:5000']
                ,'file' => ['required', 'mimes:jpeg,png', 'max:5000']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $thumbnail = $request->file('thumbnail')->store('img');
        $eventImg = $request->file('file')->store('img');

        $insertData = [
            'admin_id' => $user->id,
            'title' => $request->title,
            'start_date' => $request->start_at,
            'end_date' => $request->end_at,
            'thumb_img_path' => '/'.$thumbnail,
            'img_path' => '/'.$eventImg
        ];

        $eventData = Event::create($insertData);

        $responseData = [
            'code' => '0'
            ,'msg' => '광고 삽입 완료'
            ,'data' => $eventData
        ];

        return response()->json($responseData, 200);
    }
    // ----------------------------------------------------------------------------------------------------
    // 노경호 ----------------------------------------------------------------------------------------------
    //신고데이터 조회(레시피)
    public function recipeReportList1() {
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

        Log::info($reportData);
        return response()->json($responseData, 200);
    }

    // 레시피신고 리스트
    public function recipeReportList() {
        $reportData = DB::table('reports')
                    ->select('recipe_boards.id as recipe_board_id', DB::raw('COUNT(reports.recipe_board_id) as report_cnt'), 'recipe_boards.title', 'users.u_nickname')
                    ->join('recipe_boards', 'reports.recipe_board_id', '=', 'recipe_boards.id')
                    ->join('users', 'recipe_boards.user_id', '=', 'users.id')
                    ->whereNotNull('reports.recipe_board_id')
                    ->groupBy('recipe_boards.id', 'recipe_boards.title', 'users.u_nickname')
                    ->orderBy('reports.created_at', 'DESC')
                    ->paginate(10);
    
        
        // $reportDataArray = $reportData->items();
        // Log::debug('이거', $reportDataArray);
        $responseData = [
            'code' => '0',
            'msg' => '레시피 리폿 리스트 획득 완료',
            'data' => $reportData
        ];
        // log::info($reportData);
        return response()->json($responseData, 200);
    }

    //게시글 신고 리스트
    public function boardReportList() {
        $reportData = DB::table('reports')
                    ->select('boards.id as board_id', DB::raw('COUNT(reports.board_id) as report_cnt'), 'boards.title', 'users.u_nickname')
                    ->join('boards', 'reports.board_id', '=', 'boards.id')
                    ->join('users', 'boards.user_id', '=', 'users.id')
                    ->whereNotNull('reports.board_id')
                    ->groupBy('boards.id', 'boards.title', 'users.u_nickname')
                    ->orderBy('reports.created_at', 'DESC')
                    ->paginate(10);
    
        // $reportDataArray = $reportData->items();
    
        $responseData = [
            'code' => '0',
            'msg' => '게시글 리폿 리스트 획득 완료',
            'data' => $reportData
        ];
        // log::info($reportData);
        return response()->json($responseData, 200);
    }

    // 댓글신고 리스트
    public function commentReportList() {
        $reportData = DB::table('reports')
                    ->select('comments.id as comments_id', DB::raw('COUNT(reports.comment_id) as report_cnt'), 'comments.content', 'users.u_nickname')
                    ->join('comments', 'reports.comment_id', '=', 'comments.id')
                    ->join('users', 'comments.user_id', '=', 'users.id')
                    ->whereNotNull('reports.comment_id')
                    ->groupBy('comments.id', 'comments.content', 'users.u_nickname')
                    ->orderBy('reports.created_at', 'DESC')
                    ->paginate(10);
    
        // $reportDataArray = $reportData->items();
    
        $responseData = [
            'code' => '0',
            'msg' => '댓글리폿 리스트 획득 완료',
            'data' => $reportData
        ];
        // log::info($reportData);
        return response()->json($responseData, 200);
    }

    // 신고 갯수 받아오기
    public function countReport() {
        $reportData = DB::table('reports')
        ->selectRaw('COUNT(board_id) AS board_report_count')
        ->selectRaw('COUNT(recipe_board_id) AS recipe_board_report_count')
        ->selectRaw('COUNT(comment_id) AS comment_report_count')
        ->first();

        $responseData = [
            'code' => '0',
            'msg' => '신고 갯수 획득 완료',
            'data' => $reportData
        ];
        // log::info($reportData);
        return response()->json($responseData, 200);
    }

    //------------------------------------------------------------------------------------------------------
}
