<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class ReportController extends Controller
{
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
                            ->select('report_user.u_nickname as report_user_nickname', 'users.u_nickname', 'reports.content', 'recipe_boards.title', 'recipe_boards.id as recipe_board_id', 'users.id')
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
                            ->select('report_user.u_nickname as report_user_nickname', 'users.u_nickname', 'reports.content', 'boards.title', 'boards.id as board_id', 'users.id')
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
                            ->select('report_user.u_nickname as report_user_nickname', 'users.u_nickname', 'reports.content', 'comments.content', 'comments.id as comment_id', 'users.id')
                            ->get();

        $responseData = [
            'code' => '1'
            ,'msg' => '신고내역 획득.'
            ,'data' => $reportData
        ];
              
        return response()->json($responseData, 200);
    }
}
