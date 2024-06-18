<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewToBoardTable extends Migration
{
    public function up()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->integer('views')->nullable()->after('content');
        });

        Schema::table('recipe_boards', function (Blueprint $table) {
            $table->integer('views')->nullable()->after('video_link');
        });
    }

    public function down()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('recipe_boards', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
}

