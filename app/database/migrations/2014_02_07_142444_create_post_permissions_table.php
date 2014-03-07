<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Permission::TABLE_NAME, function(Blueprint $table)
		{
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('charity_id');
			$table->unsignedInteger('page_id');
			$table->integer('level');
			$table->timestamps();
            
            $table->primary(array('user_id', 'charity_id', 'page_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Permission::TABLE_NAME);
	}

}
