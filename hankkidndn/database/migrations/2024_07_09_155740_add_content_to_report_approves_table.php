<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentToReportApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_approves', function (Blueprint $table) {
            $table->string('content')->after('user_id'); // 또는 원하는 위치에 추가
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_approves', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
}

