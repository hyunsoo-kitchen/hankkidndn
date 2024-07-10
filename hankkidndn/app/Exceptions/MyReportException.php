<?php
namespace App\Exceptions;

use Exception;

class MyReportException extends Exception {
    /**
     *  에러 메세지 리스트
     * 
     * @return Array 에러메세지 배열
     */
    public function context() {
        return [
            'E30' => ['status' => 401, 'msg' => '이 계정은 정지된 계정입니다. 정지 기간 : '],
        ];
    }
}