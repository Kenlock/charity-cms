<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(User::TABLE_NAME, function(Blueprint $table)
		{
			$table->increments('user_id');

            // name
			$table->string('firstname', 100);
			$table->string('lastname', 100);

			$table->string('email', 100)->unique();
			$table->string('password', 64);

            // user for the about page
			$table->text('description')->nullable();

            // charity's logo, icon or avatar
			$table->string('image')->nullable();

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
		Schema::drop(User::TABLE_NAME);
	}

}
