<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentsLikes;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    // 레시피 게시글 댓글 작성
    public function commentRecipeInsert(Request $request, $id) {
        $user = Auth::user();

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

        $insertData = [
            'cocomment' => $id,
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

    // 댓글 수정 처리
    public function commentUpdate(Request $request, $id) {
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

}
