<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAutheException;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MypageController extends Controller
{
    public function update(Request $request) {
        Log::debug('회원 정보 수정', $request->all());

        // TODO : 발리데이션 처리 


        // 유저정보 획득
        // $userInfo = User::find(Session::id());
        $userInfo = Users::find(1); // TODO :  나중에 지우기

        // 업데이트 할 리퀘스트 데이터 셋팅
        $userInfo->u_post = $request->u_post;
        $userInfo->u_address = $request->u_address;
        $userInfo->u_detail_address = $request->u_detail_address;
        $userInfo->u_nickname = $request->u_nickname;
        $userInfo->u_phone_num = implode('-', $request->only('first_num', 'middle_num', 'last_num'));

        // 비밀번호 확인
        if(!Hash::check($request->u_password, $userInfo->u_password)) {
            throw new MyAutheException('E21');
        }

        // 유저정보 갱신
        $userInfo->save();

        $response = [
            'code' => 0,
            'msg' => '회원 정보 수정 완료',
            'data' => $userInfo
        ];

        return response()->json($response, 200);
    }
}
