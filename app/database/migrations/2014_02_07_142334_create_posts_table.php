<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Post::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('page_id');
			$table->unsignedInteger('view_id');
			$table->string('title');
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
		Schema::drop(Post::TABLE_NAME);
	}

}
