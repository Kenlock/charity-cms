<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Charity::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('charity_id');
			$table->string('name', 255);
			$table->unsignedInteger('charity_category_id');
			$table->text('description');
			$table->string('image', 255)->nullable();
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
		Schema::drop(Charity::TABLE_NAME);
	}

}
