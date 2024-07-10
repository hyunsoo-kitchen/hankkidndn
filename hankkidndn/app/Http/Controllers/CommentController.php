<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Comment;
use App\Models\CommentsLikes;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    // 레시피 게시글 댓글 작성
    public function commentRecipeInsert(Request $request, $id) {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['recipe_board_id'] = $id;

        $requestData = $request->all();


        $validator = Validator::make(
            $requestData
            ,[
                'recipe_board_id' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:500']
                ,'user_id' => ['required', 'regex:/^[0-9]+$/']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $insertData = [
            'recipe_board_id' => $id,
            'content' => $request->content,
            'user_id' => $user->id,
        ];

        $comment = Comment::create($insertData);

        $commentId = $comment->id;
        
        $commentData = Comment::select('comments.*', 'users.u_nickname')
                            ->join('users', 'comments.user_id', '=', 'users.id')
                            ->where('comments.id', '=' , $commentId)
                            ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $commentData
        ];

        return response()->json($responseData, 200);
    }

    // 보드 게시글 댓글 작성하기
    public function commentInsert(Request $request, $id) {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['board_id'] = $id;

        $requestData = $request->all();

        $validator = Validator::make(
            $requestData
            ,[
                'board_id' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:500']
                ,'user_id' => ['required', 'regex:/^[0-9]+$/']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $insertData = [
            'board_id' => $id,
            'content' => $request->content,
            'user_id' => $user->id,
        ];

        $comment = Comment::create($insertData);

        $commentId = $comment->id;
        
        $commentData = Comment::select('comments.*', 'users.u_nickname')
                            ->join('users', 'comments.user_id', '=', 'users.id')
                            ->where('comments.id', '=' , $commentId)
                            ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $commentData
        ];

        return response()->json($responseData, 200);
    }

    // 댓글 삭제 처리
    public function commentDelete($id) {
        Comment::destroy($id);

        $data = Comment::withTrashed()->find($id);
        $responseData = [
            'code' => '0'
            ,'msg' => '글 삭제 완료'
            ,'data' => $data
        ];

        return response()->json($responseData);
    }

    // 보드 게시글 대댓글 작성하기
    public function cocommentInsert(Request $request, $id) {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['cocomment'] = $id;

        Log::debug($request->board_id);
        $requestData = $request->all();

        $validator = Validator::make(
            $requestData
            ,[
                'cocomment' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:500']
                ,'user_id' => ['required', 'regex:/^[0-9]+$/']
                ,'board_id' => ['regex:/^[0-9]+$/']
                ,'recipe_board_id' => ['regex:/^[0-9]+$/']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $insertData = [
            'cocomment' => $id,
            'content' => $request->content,
            'board_id' => $request->board_id,
            'recipe_board_id' => $request->recipe_board_id,
            'user_id' => $user->id,
        ];

        $comment = Comment::create($insertData);

        $commentId = $comment->id;
        
        $commentData = Comment::select('comments.*', 'users.u_nickname')
                            ->join('users', 'comments.user_id', '=', 'users.id')
                            ->where('comments.id', '=' , $commentId)
                            ->first();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $commentData
        ];

        return response()->json($responseData, 200);
    }

    // 댓글 수정 처리
    public function commentUpdate(Request $request, $id) {

        $requestData = $request->all();

        $validator = Validator::make(
            $requestData
            ,[
                'content' => ['required', 'max:500']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $insertData = ['content' => $request->content];

        $commentData = Comment::find($id);

        $commentData->update($insertData);

        $data = Comment::where('comments.id', '=', $id)
                        ->join('users', 'users.id', '=', 'comments.user_id')
                        ->select('comments.*', 'users.u_nickname')
                        ->first();

        // 레스폰스 처리
        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $data
        ];

        return response()->json($responseData, 200);
    }

    // 댓글 좋아요 처리
    public function commentLike($id) {
        DB::beginTransaction();
        // like 검색
        $likeData = CommentsLikes::where('user_id', Auth::id())
                            ->where('comment_id', $id)
                            ->first();
        if(isset($likeData)) {
            $likeData->like_chk = $likeData->like_chk == '0' ? '1' : '0';
        } else {
            $likeData = new CommentsLikes();
            $likeData->user_id = Auth::id();
            $likeData->comment_id = $id;
            $likeData->like_chk = '1';
        }
        $likeData->save();

        // comments 갱신
        $commentData = Comment::find($id);
        if($likeData->like_chk == '1') {
            $commentData->likes_num += 1;
        } else {
            $commentData->likes_num -= 1;
        }
        $commentData->save();
        DB::commit();

        $responseData = [
            'code' => '0'
            ,'msg' => '좋아요 완료'
            ,'data' => $likeData
        ];

        return response()->json($responseData, 200);
    }

    // 댓글 갯수 가져오기
    public function getBoardCountComment($id) {
        $commentCount = Comment::where('board_id', '=', $id)
                        ->withTrashed()
                        ->count();

        $responseData = [
        'code' => '0'
        ,'msg' => '신고 완료'
        ,'data' => $commentCount
        ];

        return response()->json($responseData, 200);
    }

    // 댓글 갯수 가져오기
    public function getRecipeCountComment($id) {
        $commentCount = Comment::where('recipe_board_id', '=', $id)
                        ->withTrashed()
                        ->count();

        $responseData = [
        'code' => '0'
        ,'msg' => '신고 완료'
        ,'data' => $commentCount
        ];

        return response()->json($responseData, 200);
    }
}
