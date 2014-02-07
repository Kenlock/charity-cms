<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Page::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('page_id');
			$table->unsignedInteger('charity_id');
			$table->string('title', 255);
			$table->unsignedInteger('default_view_id');
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
		Schema::drop(Page::TABLE_NAME);
	}

}
