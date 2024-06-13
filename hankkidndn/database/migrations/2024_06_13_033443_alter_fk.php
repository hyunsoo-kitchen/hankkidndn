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
        Schema::table('recipe_boards', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('boards_type_id')->references('id')->on('boards_type');
        });
        
        Schema::table('recipe_likes', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recipe_board_id')->references('id')->on('recipe_boards');
        });

        Schema::table('boards', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('boards_type_id')->references('id')->on('boards_type');
        });
        
        Schema::table('boards_likes', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('board_id')->references('id')->on('boards');
        });

        Schema::table('board_images', function(Blueprint $table) {
            $table->foreign('board_id')->references('id')->on('boards');
        });

        Schema::table('comments', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recipe_board_id')->references('id')->on('recipe_boards');
            $table->foreign('board_id')->references('id')->on('boards');
        });

        Schema::table('comments_likes', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('comment_id')->references('id')->on('comments');
        });

        Schema::table('recipe_stuffs', function(Blueprint $table) {
            $table->foreign('recipe_board_id')->references('id')->on('recipe_boards');
        });

        Schema::table('recipe_programs', function(Blueprint $table) {
            $table->foreign('recipe_board_id')->references('id')->on('recipe_boards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipe_boards', function(Blueprint $table) {
            // $table->dropforeign(['user_id']);
            $table->dropforeign(['boards_type_id']);
        });
        
        Schema::table('recipe_likes', function(Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropforeign(['recipe_board_id']);
        });

        Schema::table('boards', function(Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropforeign(['boards_type_id']);
        });
        
        Schema::table('boards_likes', function(Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropforeign(['board_id']);
        });

        Schema::table('board_images', function(Blueprint $table) {
            $table->dropforeign(['board_id']);
        });

        Schema::table('comments', function(Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropforeign(['recipe_board_id']);
            $table->dropforeign(['board_id']);
        });

        Schema::table('comments_likes', function(Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropforeign(['comment_id']);
        });

        Schema::table('recipe_stuffs', function(Blueprint $table) {
            $table->dropforeign(['recipe_board_id']);
        });

        Schema::table('recipe_programs', function(Blueprint $table) {
            $table->dropforeign(['recipe_board_id']);
        });
    }
};