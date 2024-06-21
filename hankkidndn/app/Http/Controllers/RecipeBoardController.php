<?php

namespace App\Http\Controllers;

use App\Models\RecipeBoards;
use App\Models\RecipePrograms;
use App\Models\RecipeStuffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecipeBoardController extends Controller
{
    // 각 페이지의 리스트 획득
    public function getList($num) {
        
        if($num == 100) {
            $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->select('recipe_boards.*', 'users.u_nickname')
                                ->orderBy('recipe_boards.created_at', 'DESC')
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
            ,'msg' => '게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function getDetail($id) {
        $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                    ->leftJoin('recipe_likes', 'recipe_likes.recipe_board_id', '=', 'recipe_boards.id')
                                    ->where('recipe_boards.id', '=', $id)
                                    ->select('recipe_boards.*', 'users.u_nickname', 'users.profile','recipe_likes.like_chk')
                                    ->first();

        $recipeProgramData = RecipePrograms::where('recipe_board_id', '=', $id)
                                            ->select('img_path', 'program_content', 'order')
                                            ->get();

        $recipeStuffData = RecipeStuffs::where('recipe_board_id', '=', $id)
                                        ->select('stuff', 'stuff_gram')
                                        ->orderBy('id', 'DESC')
                                        ->get();

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $recipeData
            ,'program' => $recipeProgramData
            ,'stuff' => $recipeStuffData
        ];


        return response()->json($responseData, 200);

    }

    public function search(Request $request)
    {
        $query = $request->search;

        $results = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->select('recipe_boards.*', 'users.u_nickname')
                                ->where('title', 'like', "%{$query}%")
                                ->paginate(16);

        $responseData = [
            'code' => '0'
            ,'msg' => '검색 게시글 획득 완료'
            ,'data' => $results->toArray()
        ];

        return response()->json($responseData, 200);
    }

    
}
