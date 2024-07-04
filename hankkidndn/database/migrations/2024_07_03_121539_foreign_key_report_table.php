<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('board_id')->references('id')->on('boards');
            $table->foreign('recipe_board_id')->references('id')->on('recipe_boards');
            $table->foreign('comment_id')->references('id')->on('comments');
            $table->foreign('report_type_id')->references('id')->on('report_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function(Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropforeign(['board_id']);
            $table->dropforeign(['recipe_board_id']);
            $table->dropforeign(['comment_id']);
            $table->dropforeign(['report_type_id']);
        });
    }
};
