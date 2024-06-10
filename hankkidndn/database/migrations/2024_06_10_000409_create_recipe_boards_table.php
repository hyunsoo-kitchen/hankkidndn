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
        Schema::create('recipe_boards', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('boards_type_id', 1);
            $table->integer('likes_num')->default(0);
            $table->string('title', 100);
            $table->string('content', 1000);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_boards');
    }
};
