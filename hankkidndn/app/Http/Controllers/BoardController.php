<?php

namespace App\Http\Controllers;

use App\Models\BoardImages;
use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    // 보드 게시글 리스트 획득 및 페이지네이션
    public function getList($num) {
        $boardData = Boards::join('users', 'users.id', '=', 'boards.user_id')
                            ->select('boards.*', 'users.u_nickname')
                            ->where('boards_type_id', '=', $num)
                            ->orderBy('boards.created_at', 'DESC')
                            ->paginate(10);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 보드 게시글 획득
    public function getDetail($id) {
        $boardData = Boards::join('users', 'users.id', '=', 'boards.user_id')
                            ->select('boards.*', 'users.u_nickname')
                            ->where('boards.id', '=', $id)
                            ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData
        ];

        return response()->json($responseData, 200);
    }

    // 보드 게시글 삭제 처리
    public function delete($id) {

        Boards::destroy($id);

        $responseData = [
            'code' => '0'
            ,'msg' => '글 삭제 완료'
            ,'data' => $id
        ];

        return response()->json($responseData);
    }

    public function boardInsert(Request $request) {

        $user = Auth::user();
        $request['user_id'] = $user->id;

        // 데이터들을 배열 형태로 반환
        $insertData = $request->all();

        // 제목과 내용만 보드테이블에 작성
        $boardData = Boards::create($insertData);

        // 작성한 게시글의 번호 획득
        $boardId = $boardData->id;

        // 배열형태의 이미지를 foreach로 돌려서 따로 저장
        foreach ($request->file('images') as $image) {
            $path = '/'.$image->store('img');

            BoardImages::create([
                'board_id' => $boardId,
                'img_path' => $path
            ]);
        }
        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $boardData
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
