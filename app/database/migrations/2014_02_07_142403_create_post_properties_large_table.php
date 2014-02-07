<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPropertiesLargeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(PostPropertyLarge::TABLE_NAME, function(Blueprint $table)
		{
			$table->unsignedInteger('post_id');
			$table->string('title', 255);
			$table->text('content');
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
		Schema::drop(PostPropertyLarge::TABLE_NAME);
	}

}
