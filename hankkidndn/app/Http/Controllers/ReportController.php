<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Boards;
use App\Models\Comment;
use App\Models\RecipeBoards;
use App\Models\Report;
use App\Models\ReportApprove;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class ReportController extends Controller
{
    // 보드 신고기능
    public function boardReport(Request $request, $id) {

        $user = Auth::user();

        $reportChk = Report::where('user_id', '=', $user->id)
                        ->where('board_id', '=', $id)
                        ->first();

        if(!isset($reportChk)) {

            $request['user_id'] = $user->id;
            $request['board_id'] = $id;
    
            $requestData = $request->all();
            
            $validator = Validator::make(
                $requestData
                ,[
                    'user_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'board_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'report_type' => ['required', 'regex:/^[0-9]+$/']
                    ,'content' => ['required', 'max:100']
                ]
            );
    
            if($validator->fails()) {
                Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }
    
            $insertData = [
                'user_id' => $request->user_id,
                'board_id' => $request->board_id,
                'report_type_id' => $request->report_type,
                'content' => $request->content,
            ];
    
            $reportData = Report::create($insertData);
    
            // 레스폰스 처리
            $responseData = [
                'code' => '0'
                ,'msg' => '신고 완료'
                ,'data' => $reportData
            ];
    
            return response()->json($responseData, 200);
        } else {
            $responseData = [
                'code' => '1'
                ,'msg' => '이미 신고가 접수되었습니다.'
            ];

            return response()->json($responseData, 200);
        }
    }

    // 레시피 신고기능
    public function recipeReport(Request $request, $id) {

        $user = Auth::user();

        $reportChk = Report::where('user_id', '=', $user->id)
                        ->where('recipe_board_id', '=', $id)
                        ->first();

        if(!isset($reportChk)) {

            $request['user_id'] = $user->id;
            $request['recipe_board_id'] = $id;
    
            $requestData = $request->all();
            
            $validator = Validator::make(
                $requestData
                ,[
                    'user_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'recipe_board_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'report_type' => ['required', 'regex:/^[0-9]+$/']
                    ,'content' => ['required', 'max:100']
                ]
            );
    
            if($validator->fails()) {
                Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }
    
            $insertData = [
                'user_id' => $request->user_id,
                'recipe_board_id' => $request->recipe_board_id,
                'report_type_id' => $request->report_type,
                'content' => $request->content,
            ];
    
            $reportData = Report::create($insertData);
    
            // 레스폰스 처리
            $responseData = [
                'code' => '0'
                ,'msg' => '신고 완료'
                ,'data' => $reportData
            ];
    
            return response()->json($responseData, 200);
        } else {
            $responseData = [
                'code' => '1'
                ,'msg' => '이미 신고가 접수되었습니다.'
            ];

            return response()->json($responseData, 200);
        }
    }

    // 댓글 신고 기능
    public function commnetReport(Request $request, $id) {

        $user = Auth::user();

        $reportChk = Report::where('user_id', '=', $user->id)
                        ->where('comment_id', '=', $id)
                        ->first();

        if(!isset($reportChk)) {

            $request['user_id'] = $user->id;
            $request['comment_id'] = $id;
    
            $requestData = $request->all();
            
            $validator = Validator::make(
                $requestData
                ,[
                    'user_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'comment_id' => ['required', 'regex:/^[0-9]+$/']
                    ,'report_type' => ['required', 'regex:/^[0-9]+$/']
                    ,'content' => ['required', 'max:100']
                ]
            );
    
            if($validator->fails()) {
                Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }
    
            $insertData = [
                'user_id' => $request->user_id,
                'comment_id' => $request->comment_id,
                'report_type_id' => $request->report_type,
                'content' => $request->content,
            ];
    
            $reportData = Report::create($insertData);
    
            // 레스폰스 처리
            $responseData = [
                'code' => '0'
                ,'msg' => '신고 완료'
                ,'data' => $reportData
            ];
    
            return response()->json($responseData, 200);
        } else {
            $responseData = [
                'code' => '1'
                ,'msg' => '이미 신고가 접수되었습니다.'
            ];

            return response()->json($responseData, 200);
        }
    }

    // 레시피 신고내역 상세보기
    public function getRecipeReport($id) {
        $reportData = Report::where('recipe_board_id', $id)
                            ->join('users as report_user', 'report_user.id', '=', 'reports.user_id')
                            ->join('recipe_boards', 'recipe_boards.id', '=', 'reports.recipe_board_id')
                            ->join('users', 'users.id', '=', 'recipe_boards.user_id') // 여기에서는 recipe_boards.user_id가 아닌 실제 컬럼명을 사용해야 합니다.
                            ->select('report_user.u_nickname as report_user_nickname', 'users.u_nickname', 'reports.content', 'recipe_boards.title', 'recipe_boards.id as recipe_board_id', 'reports.id as report_id', 'users.id')
                            ->get();

        $responseData = [
            'code' => '1'
            ,'msg' => '신고내역 획득.'
            ,'data' => $reportData
        ];
              
        return response()->json($responseData, 200);
    }

    // 보드 신고내역 상세보기
    public function getBoardReport($id) {
        $reportData = Report::where('board_id', $id)
                            ->join('users as report_user', 'report_user.id', '=', 'reports.user_id')
                            ->join('boards', 'boards.id', '=', 'reports.board_id')
                            ->join('users', 'users.id', '=', 'boards.user_id')
                            ->select('report_user.u_nickname as report_user_nickname', 'users.u_nickname', 'reports.content', 'boards.title', 'boards.id as board_id', 'reports.id as report_id', 'users.id')
                            ->get();

        $responseData = [
            'code' => '1'
            ,'msg' => '신고내역 획득.'
            ,'data' => $reportData
        ];
              
        return response()->json($responseData, 200);
    }

    // 댓글 신고내역 상세보기
    public function getCommentReport($id) {
        $reportData = Report::where('comment_id', $id)
                            ->join('users as report_user', 'report_user.id', '=', 'reports.user_id')
                            ->join('comments', 'comments.id', '=', 'reports.comment_id')
                            ->join('users', 'users.id', '=', 'comments.user_id')
                            ->select('report_user.u_nickname as report_user_nickname', 'users.u_nickname', 'reports.content', 'comments.content', 'comments.id as comment_id', 'reports.id as report_id', 'users.id')
                            ->get();

        $responseData = [
            'code' => '1'
            ,'msg' => '신고내역 획득.'
            ,'data' => $reportData
        ];
              
        return response()->json($responseData, 200);
    }

    // 레시피 게시글 블라인드 처리
    public function recipeApprove(Request $request) {
        $recipeData = RecipeBoards::find($request->recipe_board_id);
        $reportData = Report::where('recipe_board_id', $request->recipe_board_id)
                        ->get();

        $recipeData->blind_flg = 1;
        
        $recipeData->save();

        foreach ($reportData as $report) {
            $report->approve_chk = 1;
            $report->save();
        }

        $approveDate = $request->approve_date;

        if( $approveDate == 1) {
            $insertData = [
                'content' => $request->content,
                'period' => '3일',
                'end_date' => Carbon::now()->addDays(3),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 2) {
            $insertData = [
                'content' => $request->content,
                'period' => '7일',
                'end_date' => Carbon::now()->addDays(7),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 3 ) {
            $insertData = [
                'content' => $request->content,
                'period' => '30일',
                'end_date' => Carbon::now()->addDays(30),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 4 ){
            $insertData = [
                'content' => $request->content,
                'period' => '영구정지',
                'end_date' => Carbon::create(9999, 12, 30),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        };
        
        $responseData = [
            'code' => '1'
            ,'msg' => '승인처리완료.'
            ,'data' => $reportData
        ];
              
        return response()->json($responseData, 200);
    }

    // 게시글 블라인드 처리
    public function boardApprove(Request $request) {
        $boardData = Boards::find($request->board_id);
        $reportData = Report::where('board_id', $request->board_id)
                        ->get();

        $boardData->blind_flg = 1;
        
        $boardData->save();

        foreach ($reportData as $report) {
            $report->approve_chk = 1;
            $report->save();
        }

        $approveDate = $request->approve_date;

        if( $approveDate == 1) {
            $insertData = [
                'content' => $request->content,
                'period' => '3일',
                'end_date' => Carbon::now()->addDays(3),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 2) {
            $insertData = [
                'content' => $request->content,
                'period' => '7일',
                'end_date' => Carbon::now()->addDays(7),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 3 ) {
            $insertData = [
                'content' => $request->content,
                'period' => '30일',
                'end_date' => Carbon::now()->addDays(30),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 4 ){
            $insertData = [
                'content' => $request->content,
                'period' => '영구정지',
                'end_date' => Carbon::create(9999, 12, 30),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        };

        $responseData = [
            'code' => '1'
            ,'msg' => '승인처리완료.'
            ,'data' => $boardData
        ];
              
        return response()->json($responseData, 200);
    }

    // 댓글 블라인드 처리
    public function commentApprove(Request $request) {
        $commentData = Comment::find($request->comment_id);
        $reportData = Report::where('comment_id', $request->comment_id)
                        ->get();

        $commentData->blind_flg = 1;

        $commentData->save();

        foreach ($reportData as $report) {
            $report->approve_chk = 1;
            $report->save();
        }

        $approveDate = $request->approve_date;

        if( $approveDate == 1) {
            $insertData = [
                'content' => $request->content,
                'period' => '3일',
                'end_date' => Carbon::now()->addDays(3),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 2) {
            $insertData = [
                'content' => $request->content,
                'period' => '7일',
                'end_date' => Carbon::now()->addDays(7),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 3 ) {
            $insertData = [
                'content' => $request->content,
                'period' => '30일',
                'end_date' => Carbon::now()->addDays(30),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        } else if ( $approveDate == 4 ){
            $insertData = [
                'content' => $request->content,
                'period' => '영구정지',
                'end_date' => Carbon::create(9999, 12, 30),
                'user_id' => $request->user_id
            ]; 
            ReportApprove::create($insertData);
        };

        $responseData = [
            'code' => '1'
            ,'msg' => '승인처리완료.'
            ,'data' => $commentData
        ];
              
        return response()->json($responseData, 200);
    }

    public function recipeReject($id) {
        $recipeData = RecipeBoards::find($id);
        $reportData = Report::where('recipe_board_id', $id)
                        ->get();

        $recipeData->blind_flg = 0;
        
        $recipeData->save();

        foreach ($reportData as $report) {
            $report->approve_chk = 2;
            $report->save();
        }

        $responseData = [
            'code' => '1'
            ,'msg' => '비승인처리완료.'
            ,'data' => $recipeData
        ];
              
        return response()->json($responseData, 200);
    }

    public function boardReject($id) {
        $boardData = Boards::find($id);
        $reportData = Report::where('board_id', $id)
                        ->get();

        $boardData->blind_flg = 0;
        
        $boardData->save();

        foreach ($reportData as $report) {
            $report->approve_chk = 2;
            $report->save();
        }
        
        $responseData = [
            'code' => '1'
            ,'msg' => '비승인처리완료.'
            ,'data' => $boardData
        ];
              
        return response()->json($responseData, 200);
    }

    public function commentReject($id) {
        $commentData = Comment::find($id);
        $reportData = Report::where('comment_id', $id)
                        ->get();

        $commentData->blind_flg = 0;
        
        $commentData->save();

        foreach ($reportData as $report) {
            $report->approve_chk = 2;
            $report->save();
        }
                
        $responseData = [
            'code' => '1'
            ,'msg' => '비승인처리완료.'
            ,'data' => $commentData
        ];
              
        return response()->json($responseData, 200);
    }

    // 유저 제재 기록 조회
    public function getApproveUserInfo($id) {
        $userData = ReportApprove::where('user_id', $id)
                                    ->join('users', 'users.id', '=', 'report_approves.user_id')
                                    ->select('report_approves.*', 'users.u_nickname')
                                    ->get();

        $responseData = [
            'code' => '1'
            ,'msg' => '유저정보획득완료.'
            ,'data' => $userData
        ];
                
        return response()->json($responseData, 200);
    }
}
