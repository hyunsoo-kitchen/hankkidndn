<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Comment;
use App\Models\RecipeBoards;
use App\Models\RecipeLikes;
use App\Models\RecipePrograms;
use App\Models\RecipeStuffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
                                ->orderBy('recipe_boards.created_at', 'DESC')
                                ->paginate(16);                       

        }
        
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];

        return response()->json($responseData, 200);
    }

    // 레시피 페이지 작성 처리
    public function recipeInsert(Request $request) {
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
                ,'thumbnail' => ['required', 'mimes:jpeg,png,gif', 'max:2048']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        $thumbnail = '/'.$request->file('thumbnail')->store('img');

        $insertData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'boards_type_id' => $request->input('boards_type_id'),
            'video_link' => $request->input('video'),
            'thumbnail' => $thumbnail,
            'user_id' => $user->id
        ];

        $recipeData = RecipeBoards::create($insertData);

        $recipeId = $recipeData->id;

        // 레시피 재료 처리

        $stuff_gram = $request->input('stuff_gram');

        if($request->input('stuff')) {
            // 배열형태의 이미지를 foreach로 돌려서 따로 저장
            foreach ($request->input('stuff') as $index => $stuff) {

                //유효성 검사
                $validator = Validator::make([
                    'stuff' . $index => $stuff,
                    'stuff_gram' . $index => $stuff_gram[$index]
                ],
                [
                    'stuff' . $index => 'required|max:50',
                    'stuff_gram' . $index => 'required|max:50'
                ]
                );
                
                // 유효성 검사 실패 체크
                if($validator->fails()) {
                    Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                    throw new MyValidateException('E01');
                }

                RecipeStuffs::create([
                    'recipe_board_id' => $recipeId,
                    'stuff_gram' => $stuff_gram[$index],
                    'stuff' => $stuff
                ]);
            }
        }
        // Log::debug('재료 완료');
        // 레시피 과정 내용과 이미지 함께 처리
        $texts = $request->input('list');

        $files = $request->file('file');
    
        if ($request->file('file')) {
            foreach ($files as $index => $file) {

                //유효성 검사
                $validator = Validator::make([
                    'file_' . $index => $file,
                    'texts_' . $index => $texts[$index]
                ],
                [
                    'file_' . $index => 'required|mimes:jpeg,png,gif|max:102400',
                    'texts_' . $index => 'required|max:1000'
                ]
                );

                // 유효성 검사 실패 체크
                if($validator->fails()) {
                    Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                    throw new MyValidateException('E01');
                }

                $path = '/'.$file->store('img');
            
                RecipePrograms::create([
                    'recipe_board_id' => $recipeId,
                    'img_path' => $path,
                    'program_content' => $texts[$index],
                    'order' => $index + 1
                ]);
            }
        } 


        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $recipeData
        ];

        return response()->json($responseData, 200);
    }

    // 레시피 디테일 정보 획득
    public function getDetail($id) {
        $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                    ->leftJoin('recipe_likes', 'recipe_likes.recipe_board_id', '=', 'recipe_boards.id')
                                    ->where('recipe_boards.id', '=', $id)
                                    ->select('recipe_boards.*', 'users.u_nickname', 'users.profile','recipe_likes.like_chk')
                                    ->first();

        $recipeProgramData = RecipePrograms::where('recipe_board_id', '=', $id)
                                            ->select('img_path', 'program_content', 'order')
                                            ->orderBy('order', 'ASC')
                                            ->get();

        $recipeStuffData = RecipeStuffs::where('recipe_board_id', '=', $id)
                                        ->select('stuff', 'stuff_gram')
                                        ->orderBy('id', 'ASC')
                                        ->get();

        $commentData = Comment::select('comments.*', 'comments_likes.like_chk', 'users.u_nickname')
                                ->leftJoin('comments_likes', 'comments_likes.comment_id', '=', 'comments.id')
                                ->join('users', 'users.id', '=', 'comments.user_id')
                                ->where('comments.recipe_board_id', '=', $id)
                                ->whereNull('comments.cocomment')
                                ->withTrashed()
                                ->get();
        
        $cocommentData = Comment::select('comments.*', 'comments_likes.like_chk', 'users.u_nickname')
                                ->leftJoin('comments_likes', 'comments_likes.comment_id', '=', 'comments.id')
                                ->join('users', 'users.id', '=', 'comments.user_id')
                                ->whereNotNull('comments.cocomment')
                                ->withTrashed()
                                ->get();

        $recipeData->increment('views');

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $recipeData
            ,'program' => $recipeProgramData
            ,'stuff' => $recipeStuffData
            ,'comment' => $commentData
            ,'cocomment' => $cocommentData
        ];


        return response()->json($responseData, 200);

    }

    // 레시피 수정 정보 획득
    public function getRecipeUpdate($id) {
        $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                    ->leftJoin('recipe_likes', 'recipe_likes.recipe_board_id', '=', 'recipe_boards.id')
                                    ->where('recipe_boards.id', '=', $id)
                                    ->select('recipe_boards.*', 'users.u_nickname', 'users.profile','recipe_likes.like_chk')
                                    ->first();

        $recipeProgramData = RecipePrograms::where('recipe_board_id', '=', $id)
                                            ->select('img_path', 'program_content', 'order')
                                            ->orderBy('order', 'ASC')
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

    // 레시피 게시글 수정 처리
    public function recipeUpdate(Request $request, $id) {

        $recipeData = RecipeBoards::find($id);

        $requestData = $request->all();

        $validator = Validator::make(
            $requestData
            ,[
                'boards_type_id' => ['required', 'regex:/^[0-9]+$/']
                ,'content' => ['required', 'max:1000']
                ,'title' => ['required', 'max:50']
                ,'thumbnail' => ['nullable', 'mimes:jpeg,png,gif', 'max:2048']
            ]
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        if($request->hasFile('thumbnail')) {
            $thumbnail = '/'.$request->file('thumbnail')->store('img');
        } else {
            $thumbnail = $recipeData->thumbnail;;
        }

        $insertData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'boards_type_id' => $request->input('boards_type_id'),
            'video_link' => $request->input('video'),
            'thumbnail' => $thumbnail,
        ];

        $recipeData->update($insertData);


        RecipeStuffs::where('recipe_board_id', $id)->delete();

        // 레시피 재료 처리

        $stuff_gram = $request->input('stuff_gram');

        if($request->input('stuff')) {
            // 배열형태의 이미지를 foreach로 돌려서 따로 저장
            foreach ($request->input('stuff') as $index => $stuff) {

                //유효성 검사
                $validator = Validator::make([
                    'stuff' . $index => $stuff,
                    'stuff_gram' . $index => $stuff_gram[$index]
                ],
                [
                    'stuff' . $index => 'required|max:50',
                    'stuff_gram' . $index => 'required|max:50'
                ]
                );
                
                // 유효성 검사 실패 체크
                if($validator->fails()) {
                    Log::debug('유효성 검사 실패', $validator->errors()->toArray());
                    throw new MyValidateException('E01');
                }

                RecipeStuffs::create([
                    'recipe_board_id' => $id,
                    'stuff_gram' => $stuff_gram[$index],
                    'stuff' => $stuff
                ]);
            }
        }

        RecipePrograms::where('recipe_board_id', '=', $id)->delete();

        $updateData = json_decode($request->json);

        foreach($updateData as $key => $item) {

            $recipeData = new RecipePrograms();
            $recipeData->recipe_board_id = $id;
            $recipeData->img_path = $item->img_path;
            $recipeData->program_content = $item->program_content;
            $recipeData->order = $key + 1;

            // 프로그램 내용 및 파일 업로드 유효성 검사
            $validator = Validator::make(
                [
                    'program_content' => $item->program_content,
                    'file' => $request->file('file' . ($key + 1)),
                ],
                [
                    'program_content' => 'required|max:1000',
                    'file' => 'nullable|mimes:jpeg,png,gif|max:102400',
                ]
            );

            // 유효성 검사 실패 체크
            if ($validator->fails()) {
                Log::debug('프로그램 내용 또는 파일 업로드 유효성 검사 실패', $validator->errors()->toArray());
                throw new MyValidateException('E01');
            }

            if($request->has('file'.($key + 1))) {
                $imgPath = $request->file('file'.($key + 1))->store('img');

                $recipeData->img_path = '/'.$imgPath;
            }
            // Log::debug('테스트', $recipeData->toArray());
            $recipeData->save();
        }

        // $programData = RecipePrograms::where('recipe_board_id', '=', $id)->get();

        // for ($i = 1; $i <= 20; $i++) {
        //     $programOrder = $programData->where('order', $i)->first();
        //     if ($request->hasFile('file'.$i)) {
        //         if ($programOrder) {
        //             $programOrder->delete();
        //         }

        //         RecipePrograms::create([
        //             'recipe_board_id' => $id,
        //             'img_path' => '/'.$request->file('file'.$i)->store('img'),
        //             'program_content' => $request->input('list'.$i),
        //             'order' => $i,
        //         ]);
        //     } elseif ($programOrder) {
        //         if($request->hasFile('list'.$i)) {
        //             $programOrder->update([
        //                 'program_content' => $request->input('list'.$i) ?? '', // 기본값으로 빈 문자열 사용
        //             ]);
        //         }
        //     } else {
        //         break;
        //     }
        // }
    
        // if ($request->file('file')) {
        //     RecipePrograms::where('recipe_board_id', $id)->delete();
        //     foreach ($files as $index => $file) {
        //         $path = '/'.$file->store('img');
            
        //         RecipePrograms::create([
        //             'recipe_board_id' => $id,
        //             'img_path' => $path,
        //             'program_content' => $texts[$index],
        //             'order' => $index + 1
        //         ]);
        //     }
        // } 


        $responseData = [
            'code' => '0'
            ,'msg' => '글 작성 완료'
            ,'data' => $recipeData
        ];

        return response()->json($responseData, 200);
    }

    // 레시피 게시글 삭제 처리
    public function delete($id) {

        RecipeBoards::destroy($id);

        RecipeStuffs::where('recipe_board_id', '=', $id)->delete();

        RecipePrograms::where('recipe_board_id', '=', $id)->delete();

        $responseData = [
            'code' => '0'
            ,'msg' => '글 삭제 완료'
            ,'data' => $id
        ];

        return response()->json($responseData);
    }

    // 레시피 검색 기능
    public function search(Request $request)
    {
        $query = $request->search;

        $results = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                ->select('recipe_boards.*', 'users.u_nickname')
                                ->where('title', 'like', "%{$query}%")
                                ->orWhere('content','like',"%{$query}%")
                                ->paginate(16);

        $responseData = [
            'code' => '0'
            ,'msg' => '검색 게시글 획득 완료'
            ,'data' => $results->toArray()
        ];

        return response()->json($responseData, 200);
    }

    public function recipeLike($id) {
        // DB::beginTransaction();
        // like 검색
        $likeData = RecipeLikes::where('user_id', Auth::id())
                            ->where('recipe_board_id', $id)
                            ->first();
        if(isset($likeData)) {
            $likeData->like_chk = $likeData->like_chk == '0' ? '1' : '0';
        } else {
            $likeData = new RecipeLikes();
            $likeData->user_id = Auth::id();
            $likeData->recipe_board_id = $id;
            $likeData->like_chk = '1';
        }
        $likeData->save();

        // comments 갱신
        $recipeData = RecipeBoards::find($id);
        if($likeData->like_chk == '1') {
            $recipeData->likes_num += 1;
        } else {
            $recipeData->likes_num -= 1;
        }
        $recipeData->save();
        // DB::commit();

        $responseData = [
            'code' => '0'
            ,'msg' => '좋아요 완료'
            ,'data' => $likeData
        ];

        return response()->json($responseData, 200);
    }
}
