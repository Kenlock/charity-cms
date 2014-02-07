<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPropertiesSmallTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(PostPropertySmall::TABLE_NAME, function(Blueprint $table)
		{
			$table->unsignedInteger('post_id');
			$table->string('title', 255);
			$table->string('content', 255);
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
		Schema::drop(PostPropertySmall::TABLE_NAME);
	}

}
