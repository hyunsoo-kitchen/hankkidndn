<?php

namespace App\Http\Controllers;

use App\Models\Recipe_boards;
use Illuminate\Http\Request;

class RecipeBoardController extends Controller
{
    // 각 페이지의 리스트 획득
    public function getList($num) {
        if($num === 100) {
            $recipeData = Recipe_boards::select('recipe_boards.*', 'users.u_nickname')
                                ->join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->orderBy('recipe_boards.id', 'DESC')
                                ->limit(16)
                                ->get();
        } else if($num === 99 ) {
            $recipeData = Recipe_boards::select('recipe_boards.*', 'users.u_nickname')
                                ->join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->orderBy('recipe_boards.likes_num', 'ESC')
                                ->limit(16)
                                ->get();
        } else {
            $recipeData = Recipe_boards::select('recipe_boards.*', 'users.u_nickname')
                                ->where('boards_type_id', '=', $num)
                                ->limit(16)                        
                                ->get();
        }
        
        $responseData = [
            'code' => '0'
            ,'msg' => '추가게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
