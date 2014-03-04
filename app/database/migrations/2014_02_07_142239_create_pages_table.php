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

            // the default view posts on this page should use
			$table->unsignedInteger('default_view_id');

            // whether or not all users can make posts to this page
			$table->boolean('open_to_all')
                ->default(false);

			$table->timestamps();

            // foreign keys
			#$table->foreign('charity_id')
            #    ->references(Charity::TABLE_NAME)
            #    ->on('charity_id');
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
