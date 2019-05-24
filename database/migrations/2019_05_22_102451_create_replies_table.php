<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
	public function up()
	{
		Schema::create('replies', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id')->nullable(); // TDD 測試用
            $table->integer('topic_id')->unsigned()->default(0)->index();
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->text('content');
            $table->text('body'); // TDD 測試用
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('replies');
	}
}
