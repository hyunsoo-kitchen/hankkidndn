<?php

namespace App\Http\Controllers;

use App\Exceptions\MyValidateException;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //회원가입
    public function registration(Request $request) {
        //리퀘스트 데이터 획득
        $requestData = $request->all();
        Log::debug($requestData);
        //유효성 검사
        // $validator = Validator::make(
        //     $requestData
        //     ,[
        //         'u_name' => ['required', 'min:2', 'max:20']
        //         ,'birth_at' => ['required']
        //         ,'u_id' => ['required', 'min:4', 'max:20', 'unique:users']
        //         ,'u_password' => ['required', 'min:4', 'max:20']
        //         ,'password_chk' => ['same:u_password']
        //         ,'u_post' => ['required']
        //         ,'u_address' => ['required']
        //         ,'u_address_detail' => ['required']
        //         ,'u_phone_num' =>['required']
        //         ,'u_nickname' =>['required']
        //         ,'gender' => ['required']
        //     ] 
        // );

        // Log::debug('2');
        // // 유효성 검사 실패 체크
        // if($validator->fails()) {
        //     Log::debug('유효성 검사 실패', $validator->errors()->toArray());
        //     throw new MyValidateException('E01');
        //     }
            
        //     Log::debug('3');
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
}

