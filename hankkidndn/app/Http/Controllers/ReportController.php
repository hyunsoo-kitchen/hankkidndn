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
}
