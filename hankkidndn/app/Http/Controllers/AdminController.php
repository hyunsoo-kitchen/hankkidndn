<?php

namespace App\Http\Controllers;

use App\Exceptions\MyAutheException;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function adminLogin(Request $request) {
        // 유저 정보 획득
        $adminInfo = Admin::where('admin_id', $request->admin_id)
                    ->first();

        // 유저 정보 오류
        if(!isset($adminInfo)) {
            // 유저 없음
            throw new MyAutheException('E20');
        } else if(!(Hash::check($request->admin_password, $adminInfo->admin_password))) {
            // 비밀번호 오류
            throw new MyAutheException('E21');
        }

        Log::debug('확인완료');
        // 로그인 처리
        Auth::login($adminInfo);

        // 레스폰스 데이터 생성
        $responseData = [
            'code' => '0'
            ,'msg' => '로그인 성공'
            ,'data' => $adminInfo
        ];

        return response() -> json($responseData, 200)->cookie('admin', '1', 120, null, null, false, false);
    }

    public function adminLogout() {
        Auth::logout();
        Session::invalidate(); // 기본 세션 파기하고 새로운 세션 생성
        Session::regenerateToken(); // CSRF 토큰 재발급

        $responseData = [
            'code' => '0'
            ,'msg' => '로그아웃 완료'
        ];
        return response()
                ->json($responseData, 200)
                ->cookie('admin', '1', -1, null, null, false, false);
    }
}
