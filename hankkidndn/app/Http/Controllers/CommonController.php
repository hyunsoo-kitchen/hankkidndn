<?php

namespace App\Http\Controllers;

use App\Models\RecipeBoards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function getList() {
        $newList = RecipeBoards::select(
                                'recipe_boards.*',
                                'users.u_nickname',
                                DB::raw('IFNULL((SELECT COUNT(comments.recipe_board_id) FROM comments WHERE comments.recipe_board_id = recipe_boards.id), 0) AS cnt')
                                // DB::raw('IFNULL(recipe_likes.like_chk, \'0\') AS like_chk')
                            )
                            ->orderBy('recipe_boards.created_at', 'DESC')
                            ->limit(4)
                            ->join('users', 'users.id', '=', 'recipe_boards.user_id')
                            // ->leftJoin('recipe_likes', 'recipe_likes.recipe_board_id', '=', 'recipe_boards.id')
                            ->get();

        $bestData = RecipeBoards::select(
                                'recipe_boards.*',
                                'users.u_nickname',
                                'users.profile',
                                DB::raw('IFNULL((SELECT COUNT(comments.recipe_board_id) FROM comments WHERE comments.recipe_board_id = recipe_boards.id), 0) AS cnt')
                                // DB::raw('IFNULL(recipe_likes.like_chk, \'0\') AS like_chk')
                            )
                            // ->groupBy('recipe_boards.id')
                            ->orderBy('recipe_boards.likes_num', 'DESC')
                            ->limit(3)
                            ->join('users', 'users.id', '=', 'recipe_boards.user_id')
                            // ->leftJoin('recipe_likes', 'recipe_likes.recipe_board_id', '=', 'recipe_boards.id')
                            ->get();
        
        $responseData = [
            'code' => '0'
            ,'msg' => ''
            ,'newData' => $newList->toArray()
            ,'bestData' => $bestData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function getRecipe($id) {
        $data = RecipeBoards::find($id);

        $responseData = [
            'code' => '0'
            ,'msg' => ''
            ,'data' => $data
        ];

        return response()->json($responseData, 200);
    }
}
