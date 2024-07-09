<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlindFlgToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->integer('blind_flg');
        });

        Schema::table('recipe_boards', function (Blueprint $table) {
            $table->integer('blind_flg');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->integer('blind_flg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->dropColumn('blind_flg');
        });

        Schema::table('recipe_boards', function (Blueprint $table) {
            $table->dropColumn('blind_flg');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('blind_flg');
        });
    }
}
