<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAutheException;
use App\Exceptions\MyValidateException;
use App\Models\Boards;
use App\Models\Comment;
use App\Models\RecipeBoards;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //회원가입 - 노경호
    public function registration(Request $request) {
        //리퀘스트 데이터 획득
        $requestData = $request->all();

        Log::debug($requestData);

        //유효성 검사
        $validator = Validator::make(
            $requestData
            ,[
                'u_name' => ['required', 'min:2','max:20', 'regex:/^[가-힣]+$/u']
                ,'birth_at' => ['required']
                ,'u_id' => ['required', 'min:4', 'max:20', 'unique:users']
                ,'u_password' => ['required', 'min:4', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^]+$/u']
                ,'password_chk' => ['same:u_password']
                ,'u_post' => ['required', 'regex:/^\d{5}$/']
                ,'u_address' => ['required']
                ,'u_detail_address' => ['required']
                ,'u_phone_num' =>['required','regex:/^(01[016789]{1})-?[0-9]{3,4}-?[0-9]{4}$/']
                ,'u_nickname' =>['required']
                ,'gender' => ['required']
            ] 
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }
            
        // 작성 데이터 생성
        $insertData = $request->all();

        // 비밀번호 설정
        $insertData['u_password'] = Hash::make($request->u_password);

        // 인서트 처리
        $userInfo = Users::create($insertData);

        Log::debug('4');
        $responseData = [
            'code' => '0'
            ,'msg' => '로그아웃 완료'
            ,'data' => $userInfo
        ];

        return response()->json($responseData, 200);
    }

    // 로그인 - 노경호
    public function login(Request $request) {
        //유효성 검사
        
        // 유저 정보 획득
        $userInfo = Users::select('users.*')
                        ->where('u_id', $request->u_id)
                        ->first();

        // 유저 정보 오류
        if(!isset($userInfo)) {
            // 유저 없음
            throw new MyAutheException('E20');
        } else if(!(Hash::check($request->u_password, $userInfo->u_password))) {
            // 비밀번호 오류
            throw new MyAutheException('E21');
        }

        // 로그인 처리
        Auth::login($userInfo);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '로그인 성공'
            ,'data' => $userInfo
        ];

        return response() -> json($responseData, 200)->cookie('auth', '1', 120, null, null, false, false);
        
    }

    // 로그아웃
    public function logout() {
        Auth::logout();
        Session::invalidate(); // 기본 세션 파기하고 새로운 세션 생성
        Session::regenerateToken(); // CSRF 토큰 재발급

        $responseData = [
            'code' => '0'
            ,'msg' => '로그아웃 완료'

        ];
        return response()
                ->json($responseData, 200)
                ->cookie('auth', '1', -1, null, null, false, false);
    }

    // 마이페이지 유저정보 획득
    public function getUserInfo() {
        $user_id = Auth::id();
    
        $boardData = Users::select(
                'users.*',
                DB::raw('(SELECT COUNT(rb.user_id) FROM recipe_boards AS rb WHERE users.id = rb.user_id AND deleted_at IS null) as recipe_count'),
                DB::raw('(SELECT COUNT(boards.user_id) FROM boards WHERE users.id = boards.user_id AND boards.deleted_at IS null) as boards_count'),
                DB::raw('(SELECT COUNT(cm.user_id) FROM comments AS cm WHERE users.id = cm.user_id AND cm.deleted_at IS null) as comments_count')
            )
            ->where('users.id', $user_id)
            ->first();
    
        $responseData = [
            'code' => '0',
            'msg' => '게시글 획득 완료',
            'data' => $boardData->toArray()
        ];
          
        return response()->json($responseData, 200);
    }
    
    // 마이페이지에서 유저가 쓴 보드 리스트 획득 및 페이지네이션 
    public function getBoardListInMy() {
        $user_id = Auth::id();

        $boardData = Boards::join('users', 'users.id', '=', 'boards.user_id')
                            ->select('boards.*', 'users.u_nickname')
                            ->where('users.id', $user_id)
                            ->orderBy('boards.created_at', 'DESC')
                            ->paginate(10);
        
        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $boardData->toArray()
        ];

        return response()->json($responseData, 200);
    }
    
    // 마이페이지에서 유저가 쓴 레시피 리스트 획득 및 페이지네이션
    public function getRecipeListInMy() {
        $user_id = Auth::id();

        $recipeData = RecipeBoards::join('users', 'users.id', '=', 'recipe_boards.user_id')
                                    ->select('recipe_boards.*', 'users.u_nickname')
                                    ->where('users.id', $user_id)
                                    ->orderBy('recipe_boards.created_at', 'DESC')
                                    ->paginate(10);

        $responseData = [
            'code' => '0'
            ,'msg' => '게시글 획득 완료'
            ,'data' => $recipeData->toArray()
        ];
        
        return response()->json($responseData, 200);
    }

    // 마이페이지에서 유저가 레시피보드에서 쓴 댓글 리스트 획득 및 페이지 네이션
    public function getRecieCommentList() {
        $user_id = Auth::id();
        
        $rcommentData = Comment::join('recipe_boards', 'comments.recipe_board_id', '=', 'recipe_boards.id')
                                ->join('users', 'comments.user_id', '=', 'users.id')
                                ->select(
                                    'comments.*', 
                                    'recipe_boards.title as recipe_title', 
                                    'users.u_nickname'
                                )
                                ->where('comments.user_id', $user_id)
                                ->orderBy('comments.created_at', 'DESC')
                                ->paginate(10);

    $responseData = [
        'code' => '0',
        'msg' => '댓글 및 레시피 제목 획득 완료',
        'data' => $rcommentData->toArray()
    ];

    return response()->json($responseData, 200);
    }

    // 마이페이지에서 유저가 보드게시판에서 쓴 댓글 리스트 획득 및 페이지 네이션 
    public function getBoardCommentList() {
        $user_id = Auth::id();
        
        $bcommentData = Comment::join('boards', 'comments.board_id', '=', 'boards.id')
                          ->join('users', 'comments.user_id', '=', 'users.id')
                          ->select('comments.*', 'boards.title as title', 'users.u_nickname', 'boards.id as board_id')
                          ->where('comments.user_id', $user_id)
                          ->orderBy('comments.created_at', 'DESC')
                          ->paginate(10);

    $responseData = [
        'code' => '0',
        'msg' => '댓글 및 레시피 제목 획득 완료',
        'data' => $bcommentData->toArray()
    ];

    return response()->json($responseData, 200);
    }
    
    // 마이페이지에서 유저 비밀번호 인증을 확인
    public function authenticate(Request $request)
    {
        // 현재 인증된 사용자의 ID를 가져옵니다.
    $userId = Auth::id();

    // 사용자 정보를 데이터베이스에서 조회합니다.
    $users = Users::find($userId);
    Log::debug('비번체크 유저 ID : '.$userId);
    Log::debug('비번체크 DB PW : '. $users->u_password);
    Log::debug('비번체크 REQ PW : '. $request->u_password);
    // 사용자가 존재하는지 확인합니다.
    if (!$users) {
        return response()->json(['success' => false, 'message' => '사용자를 찾을 수 없습니다.'], 404);
    }

    // 비밀번호를 확인합니다.
    if (Hash::check($request->u_password, $users->u_password)) {
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => '비밀번호가 틀렸습니다.'], 401);
    }
    }

    //프로필 사진 등록
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // $user = auth()->user();
        // $imgData = $request->file('profile');
        // $imageName = time().$request->file('profile')->getClientOriginalName();
        // Log::debug('이미지 수정 전'.$imgData);
        // $imageManager = Image::make($user->profile);
        // $imageResized = $imageManager->resize(150, 150);
        // $imageResized->save(public_path('img').$imageName);

        // Log::debug('이미지 수정 후', $imageResized);
        // $user->profile = '/'.public_path('img').$imageName;


        $user->save();


        return response()->json($user);
    
        
    }

    // 비밀번호 수정
    public function updatePassword(Request $request)
    {
        $request->validate([
            'u_password' => ['required', 'min:4', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^]+$/u']
            ,'password_chk' => ['same:u_password']
        ]);

        $user = Auth::user();

        $userData = User::find($user->id);

        $userData->u_password = Hash::make($request->u_password);
        $userData->save();

        return response()->json(['success' => true]);
    }

    // 닉네임 변경
    public function updateNickname(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'u_nickname' => 'required|unique:users,u_nickname,' . auth()->user()->id,
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
    
        $user = auth()->user();
        $user->u_nickname = $request->u_nickname;
        $user->save();
    
        return response()->json(['success' => true]);
    }

    // 휴대폰 번호 수정
    public function updatePhonenum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'u_phone_num' => ['required', 'regex:/^(01[016789]{1})-?[0-9]{3,4}-?[0-9]{4}$/']
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = auth()->user();
        $user->u_phone_num = $request->u_phone_num;
        $user->save();

        return response()->json(['success' => true]);
    }

    // 프로필 이미지 업로드 처리
    public function profileInsert(Request $request) {
        // 파일 유효성 검사 및 저장
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif', // jpeg, png, jpg, gif 
        ]);
        
        // 이미지 파일 저장 및 경로 설정
        if ($request->file('profile')) {
        $path = $request->file('profile')->store('/img');
        } else {
            return response()->json(['error' => '이미지를 업로드해주세요.'], 400);
        }

        // 현재 인증된 사용자 정보 가져오기
        $user = auth()->user();

        // 사용자 프로필 정보 업데이트
        $user->profile = '/'.$path;
        $user->save();

        return response()->json(['success' => true, 'profile_path' => $path]);
    }

    // 생년월일 수정
    public function updateBirthat(Request $request)
    {
        $request->validate([
            'birth_at' => ['required']
        ]);

        $user = Auth::user();

        $userData = User::find($user->id);

        $userData->birth_at = $request->birth_at;
        $userData->save();

        return response()->json(['success' => true]);
    }

    // 주소 변경
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'u_post' => ['required', 'regex:/^\d{5}$/'],
            'u_address' => ['required']
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
    
        $user = auth()->user();
        $user->u_post = $request->u_post;
        $user->u_address = $request->u_address;
        $user->u_detail_address = $request->u_detail_address;
        $user->save();
    
        return response()->json(['success' => true]);
    }


}

