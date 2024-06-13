<?php

namespace App\Http\Controllers;

use App\Models\Boards;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function getList($num) {
        $recipeData = Boards::where('boards_type_id', '=', $num)
                                    ->get();
        
        $responseData = [
            'code' => '0'
            ,'msg' => '추가게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
