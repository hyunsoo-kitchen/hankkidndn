<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAutheException;
use App\Exceptions\MyValidateException;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        $insertData['u_password'] = Hash::make($request->password);

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
        } else if(!(Hash::check($request->password, $userInfo->u_password))) {
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

    //로그아웃 - 노경호
    public function logout() {
        Auth::logout(Auth::user());
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
}

