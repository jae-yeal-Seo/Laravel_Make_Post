<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('content');
            $table->string('image')->nullable();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            //누구를 참조하는지 표시안해도 id를 참조함.(users라는 테이블에 id를 참조하고 있구나)
            $table->timestamps();
        });
    }
    //migration 실행해주세요

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
    //rollback 해주세요.
}
