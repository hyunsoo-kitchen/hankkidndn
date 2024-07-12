<?php

namespace App\Http\Controllers;

use App\Models\RecipeBoards;
use Carbon\Carbon;

class RecommendController extends controller {
    public function getSeason() {
        $result = RecipeBoards::select('recipe_boards.id', 'recipe_boards.title', 'recipe_boards.views', 'recipe_boards.thumbnail', 'recipe_boards.created_at', 'users.u_nickname')
                                ->join('users', 'recipe_boards.user_id', '=', 'users.id')
                                ->whereNotNull('recipe_boards.recommend_at')
                                ->orderBy('recipe_boards.recommend_at', 'desc')
                                ->limit(4)
                                ->get();
        
        $responseData = [
            'code' => '0'
            ,'msg' => '계절 추천 레시피 획득 성공'
            ,'data' => $result->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function getFrige() {
        $result = RecipeBoards::select('recipe_boards.id', 'recipe_boards.title', 'recipe_boards.likes_num', 'recipe_boards.views', 'recipe_boards.thumbnail', 'recipe_boards.created_at', 'users.u_nickname')
                            ->join('users', 'recipe_boards.user_id', '=', 'users.id')
                            // ->whereNotNull('recipe_boards.recommend_at')
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '냉장고 털기 레시피 획득 성공'
            ,'data' => $result->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function getWeeklyBest() {

        $oneWeekAge = Carbon::now()->subWeek();
        $result = RecipeBoards::select('recipe_boards.id', 'recipe_boards.title', 'recipe_boards.views', 'recipe_boards.thumbnail', 'recipe_boards.created_at', 'users.u_nickname')
                            ->join('users', 'recipe_boards.user_id', '=', 'users.id')
                            // ->whereNotNull('recipe_boards.recommend_at')
                            ->where('recipe_boards.created_at', '>=', $oneWeekAge) // 일주일 내 데이터
                            // ->where('recipe_boards.likes_num', '>=', 80) 
                            ->orderBy('recipe_boards.views', 'desc')
                            ->limit(4)
                            ->get();
        $responseData = [
            'code' => '0'
            ,'msg' => '주간 베스트 레시피 획득 성공'
            ,'data' => $result->toArray()
        ];

        return response()->json($responseData, 200);
    }
}