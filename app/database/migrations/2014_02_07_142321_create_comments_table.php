<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Comment::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('comment_id');
			$table->unsignedInteger('post_id');
			$table->unsignedInteger('user_id');
			$table->text('comment');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Comment::TABLE_NAME);
	}

}
