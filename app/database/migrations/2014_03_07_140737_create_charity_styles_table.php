<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharityStylesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(CharityStyle::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('id');

            $table->unsignedInteger('charity_id');
            $table->string('property', 150);
            $table->string('value', 255);

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
		Schema::drop(CharityStyle::TABLE_NAME);
	}

}
