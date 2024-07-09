<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReportApproveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_approve', function (Blueprint $table) {
            // user_id 외래 키 설정
            $table->foreign('user_id')->references('id')->on('users');

            // report_id 외래 키 설정
            $table->foreign('report_id')->references('id')->on('reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_approve', function (Blueprint $table) {
            // user_id 외래 키 제거
            $table->dropForeign(['user_id']);

            // report_id 외래 키 제거
            $table->dropForeign(['report_id']);
        });
    }
}
