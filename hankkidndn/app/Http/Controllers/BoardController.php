<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function getList($num) {
        $recipeData = Boards::where('boards_type_id', '=', $num)
                            ->paginate(16);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '추가게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function boardIndex(Request $request) {
        // 인서트 처리
        $boardModel = Boards::select('boards.*', 'user_id')
                            ->join('users', 'user_id', '=', 'id')
                            ->where('user_id', Auth::id())
                            ->first();


        
        $boardModel->title = $request->title;
        $boardModel->content = $request->content;
        $boardModel->user_id = Auth::id();
        $boardModel->board_type_id = $request->board;
        $boardModel->save();

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $boardModel->toArray()
        ];

        return response()->json($responseData, 200);

    }

    public function update($id, Request $request) {
        // 게시글 조회
        $boardModel = Boards::find($id);
    
        // 게시글이 존재하지 않을 경우
        if (!$boardModel) {
            return response()->json([
                'code' => 'E01',
                'msg' => '게시글을 찾을 수 없습니다.'
            ], 404);
        }
    
        // 현재 사용자와 게시글 작성자가 일치하는지 확인 (권한 검사)
        if ($boardModel->user_id !== Auth::id()) {
            return response()->json([
                'code' => 'E02',
                'msg' => '게시글 수정 권한이 없습니다.'
            ], 403);
        }
    
        // 요청된 데이터로 게시글 업데이트
        $boardModel->title = $request->input('title');
        $boardModel->content = $request->input('content');
        $boardModel->board_type_id = $request->input('board');
    
        // 저장
        $boardModel->save();
    
        // 업데이트된 게시글 데이터를 응답
        return response()->json([
            'code' => '0',
            'msg' => '게시글 수정 완료',
            'data' => $boardModel->toArray()
        ], 200);
    }
    
}
