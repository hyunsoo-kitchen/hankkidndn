<?php

namespace App\Http\Controllers;

use App\Models\BoardImages;
use App\Models\Boards;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log;

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
        // 보드 정보 획득
        $boardData = Boards::join('users', 'users.id', '=', 'boards.user_id')
                            ->select('boards.*', 'users.u_nickname')
                            ->where('boards.id', '=', $id)
                            ->first();

        // 조회수 1  증가                    
        $boardData->increment('views');

        // 이미지 획득
        $imgData = BoardImages::select('img_path')
                                ->where('board_images.board_id', '=', $id)
                                ->get();

        $commentData = Comment::select('comments.*', 'comments_likes.like_chk', 'users.u_nickname')
                                ->leftJoin('comments_likes', 'comments_likes.comment_id', '=', 'comments.id')
                                ->join('users', 'users.id', '=', 'comments.user_id')
                                ->where('comments.board_id', $id)
                                ->whereNull('comments.cocomment')
                                ->withTrashed()
                                ->get();

        $cocommentData = Comment::select('comments.*', 'comments_likes.like_chk', 'users.u_nickname')
                                ->leftJoin('comments_likes', 'comments_likes.comment_id', '=', 'comments.id')
                                ->join('users', 'users.id', '=', 'comments.user_id')
                                ->whereNotNull('comments.cocomment')
                                ->withTrashed()
                                ->get();

        // 백에서 처리

        // $data = $commentData->toArray();
        // $ccdata = $cocommentData->toArray();

        // foreach($data as $key => $item){
        //     $data[$key]['cocomment'] = [];

        //     foreach($ccdata as $cckey => $ccItem) {
        //         if($item['id'] == $ccItem['cocomment']) {
        //             $data[$key]['cocomment'][] = $ccItem;
        //             unset($ccdata[$cckey]);
        //             break;
        //         }
        //     }
        // }

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData
            ,'img' => $imgData
            ,'comment' => $commentData
            ,'cocomment' => $cocommentData
            // ,'data' => $data
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

    // 보드 게시글 작성 처리
    public function boardInsert(Request $request) {

        $user = Auth::user();
        $request['user_id'] = $user->id;

        $insertData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'boards_type_id' => $request->input('boards_type_id'), // 기본값을 설정하여 추가합니다.
            'user_id' => $user->id
        ];

        // 데이터들을 배열 형태로 반환
        // $insertData = $request->all();

        // 제목과 내용만 보드테이블에 작성
        $boardData = Boards::create($insertData);

        // 작성한 게시글의 번호 획득
        $boardId = $boardData->id;

        // 이미지 파일이 있는지 체크
        if($request->file('file')) {
            // 배열형태의 이미지를 foreach로 돌려서 따로 저장
            foreach ($request->file('file') as $image) {
                $path = '/'.$image->store('img');
    
                BoardImages::create([
                    'board_id' => $boardId,
                    'img_path' => $path
                ]);
            }
        }
        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $boardData
        ];

        return response()->json($responseData, 200);

    }

    public function getBoardUpdate($id) {
        $boardData = Boards::join('users', 'users.id', '=', 'boards.user_id')
                            ->select('boards.*', 'users.u_nickname')
                            ->where('boards.id', '=', $id)
                            ->first();
                            
        $imgData = BoardImages::select('img_path')
                                ->where('board_images.board_id', '=', $id)
                                ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData
            ,'img' => $imgData
        ];

        return response()->json($responseData, 200);
    }

    // 게시글 수정처리
    public function boardUpdate(Request $request) {
        
        $insertData = [
            'title' => $request->title,
            'content' => $request->content,
            'boards_type_id' => $request->boards_type_id, // 기본값을 설정하여 추가합니다.
        ];
        
        $boardId = $request->num;

        $boardData = Boards::find($boardId);

        $boardData->update($insertData);

        if($request->file('file')) {
            BoardImages::where('board_id', $boardId)->delete();
        }

        if($request->file('file')) {
            // 배열형태의 이미지를 foreach로 돌려서 따로 저장
            foreach ($request->file('file') as $image) {
                $path = '/'.$image->store('img');
    
                BoardImages::create([
                    'board_id' => $boardId,
                    'img_path' => $path
                ]);
            }
        }

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $boardData
        ];

        return response()->json($responseData, 200);
    }

    // ------------이현수 레츠고------------------
    // public function viewDetail($num){
    //     $board = Boards::findOrFail($num);

    //     $board->increment('views');

    //     return response()->json([
    //         'boards' => $board,
    //         'views' => $board->views
    //     ]);
    // }
    
}
