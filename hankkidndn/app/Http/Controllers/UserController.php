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

        //유효성 검사
        //유효성 검사는 수정 할 수도 있음 TODO
        $validator = Validator::make(
            $requestData
            ,[
                'account' => ['required', 'min:4', 'max:20', 'unique:users', 'regex:/^[a-zA-Z0-9]+$/' ]
                ,'password' => ['required', 'min:4', 'max:20', 'regex:/^[a-zA-Z0-9!@#$%^]+$/u' ]
                ,'password_chk' => ['same:password']
                ,'name' => ['required', 'min:2', 'max:20', 'regex:/^[가-힣]+$/u']
                ,'gender' => ['required', 'regex:/^[0-1]{1}$/']
                ,'profile' => ['required', 'image']
            ] 
        );

        // 유효성 검사 실패 체크
        if($validator->fails()) {
            Log::debug('유효성 검사 실패', $validator->errors()->toArray());
            throw new MyValidateException('E01');
        }

        // 작성 데이터 생성
        $insertData = $request->all();

        // 파일 저장
        $insertData['profile'] = $request->file('profile')->store('profile');

        // 비밀번호 설정
        $insertData['password'] = Hash::make($request->password);

        // 인서트 처리
        $userInfo = Users::create($insertData);

        $responseData = [
            'code' => '0'
            ,'msg' => '로그아웃 완료'
            ,'data' => $userInfo
        ];

        return response()->json($responseData, 200);
    }
}

