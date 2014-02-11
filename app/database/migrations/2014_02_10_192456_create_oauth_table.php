<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(OAuth::TABLE_NAME, function(Blueprint $table)
		{
            $table->string('uid', 255);
            $table->string('provider', 100);
            $table->unsignedInteger('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(OAuth::TABLE_NAME);
	}

}
