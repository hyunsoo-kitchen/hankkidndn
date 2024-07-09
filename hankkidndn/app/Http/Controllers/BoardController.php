<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\BoardImages;
use App\Models\Boards;
use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

        // // 백에서 처리

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
        if (empty($boardData)) {
            throw new MyValidateException('E01');
        }
        

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData
            ,'img' => $imgData
            ,'comment' => $commentData
            ,'cocomment' => $cocommentData
            // ,'data2' => $data
        ];


        return response()->json($responseData, 200);
    }

    // view 증가
    public function viewUp($id) {
        $boardData = Boards::find($id);

        $boardData->increment('views');

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

    // 보드 게시글 작성 처리
    public function boardInsert(Request $request) {

        $user = Auth::user();
        $request['user_id'] = $user->id;

        $requestData = $request->all();
        
        $validator = Validator::make(
            $requestData
            ,[
                'user_id' => ['required', 'regex:/^[0-9]+$/']
                ,'boards_type_id' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:1000']
                ,'title' => ['required', 'max:50']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $insertData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'boards_type_id' => $request->input('boards_type_id'),
            'user_id' => $user->id
        ];

        // 데이터들을 배열 형태로 반환

        // 제목과 내용만 보드테이블에 작성
        $boardData = Boards::create($insertData);

        // 작성한 게시글의 번호 획득
        $boardId = $boardData->id;

        // 이미지 파일이 있는지 체크
        if($request->file('file')) {
            // 배열형태의 이미지를 foreach로 돌려서 따로 저장
            foreach ($request->file('file') as $index => $image) {

                //유효성 검사
                $validator = Validator::make(
                    ['file_' . $index => $image],
                    ['file_' . $index => 'required|mimes:jpeg,png,gif|max:102400']
                );

                // 유효성 검사 실패 체크
                if($validator->fails()) {
                    Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                    throw new MyValidateException('E01');
                }
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

    // 보드 페이지 수정글 가져오기
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

    // 보드 게시글 수정처리
    public function boardUpdate(Request $request) {

        $requestData = $request->all();

        $validator = Validator::make(
            $requestData
            ,[
                'boards_type_id' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:1000']
                ,'title' => ['required', 'max:50']
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
            foreach ($request->file('file') as $index => $image) {

                //유효성 검사
                $validator = Validator::make(
                    ['file_' . $index => $image],
                    ['file_' . $index => 'required|mimes:jpeg,png,gif|max:102400']
                );

                // 유효성 검사 실패 체크
                if($validator->fails()) {
                    Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                    throw new MyValidateException('E01');
                }

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

    public function search(Request $request, $id)
    {
        $query = $request->search;
        Log::debug('type : ' . $id);
        Log::debug('query : ' . $query);
        $results = Boards::join('users', 'users.id', '=', 'boards.user_id')
                                ->select('boards.*', 'users.u_nickname')
                                ->where('boards_type_id', '=', $id)
                                ->where('title', 'like', "%{$query}%")
                                ->paginate(10);
                                
        $responseData = [
            'code' => '0'
            ,'msg' => '검색 게시글 획득 완료'
            ,'data' => $results->toArray()
        ];

        return response()->json($responseData, 200);
    }
    public function searchName(Request $request, $id)
    {
        $query = $request->search;
        Log::debug('type : ' . $id);
        Log::debug('query : ' . $query);
        $results = Boards::join('users', 'users.id', '=', 'boards.user_id')
                                ->select('boards.*', 'users.u_nickname')
                                ->where('boards_type_id', '=', $id)
                                ->where('u_nickname', 'like', "%{$query}%")
                                ->paginate(10);
                                
        $responseData = [
            'code' => '0'
            ,'msg' => '검색 게시글 획득 완료'
            ,'data' => $results->toArray()
        ];

        return response()->json($responseData, 200);
    }
    public function event($id)
    {
        $eventData = Event::where('id', $id)
                            ->first(); 
        Log::debug($eventData);

        $responseData = [
            'code' => '0'
            ,'msg' => '검색 게시글 획득 완료'
            ,'data' => $eventData
        ];
        
        return response()->json($responseData, 200);
    }
}
