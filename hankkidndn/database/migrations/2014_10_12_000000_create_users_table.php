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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_name', 20);
            $table->string('u_id', 30);
            $table->string('u_password', 512);
            $table->string('u_nickname', 50);
            $table->string('gender', 1 )->comment('0: 남자, 1: 여자');
            $table->string('u_email', 100)->unique();
            $table->string('u_phone_num', 15 );
            $table->integer('u_post');
            $table->string('u_address', 50);
            $table->string('u_detail_address', 50);
            $table->date('birth_at');
            $table->timestamp('nickname_update_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
