<?php

namespace App\Http\Controllers;

use App\Models\RecipeBoards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipeBoardController extends Controller
{
    // 각 페이지의 리스트 획득
    public function getList($num) {
        
        if($num == 100) {
            $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->select('recipe_boards.*', 'users.u_nickname')
                                ->orderBy('recipe_boards.id', 'DESC')
                                ->paginate(16);

        } else if($num == 99 ) {
            $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->select('recipe_boards.*', 'users.u_nickname')
                                ->orderBy('recipe_boards.likes_num', 'DESC')
                                ->paginate(16);

        } else {
            $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->select('recipe_boards.*', 'users.u_nickname')
                                ->where('boards_type_id', '=', $num)
                                ->paginate(16);                       

        }
        
        $responseData = [
            'code' => '0'
            ,'msg' => '추가게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function getDetail($num) {
       
    }
}
