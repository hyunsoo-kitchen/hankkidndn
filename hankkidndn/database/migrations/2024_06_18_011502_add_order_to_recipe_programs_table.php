<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddorderToRecipeProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('recipe_programs', function (Blueprint $table) {
            $table->integer('order')->after('program_content');
        });
    }

    public function down()
    {
        Schema::table('recipe_programs', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}

