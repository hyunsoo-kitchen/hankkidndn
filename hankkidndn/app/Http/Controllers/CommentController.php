<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

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

}
