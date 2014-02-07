<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostViewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(PostView::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('post_view_id');
            $table->string('view', 255);
            $table->string('title', 255);
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
		Schema::drop(PostView::TABLE_NAME);
	}

}
