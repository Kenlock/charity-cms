<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(SocialLink::TABLE_NAME, function(Blueprint $table)
		{
            $table->increments('id');

            $table->unsignedInteger('charity_id');

            $table->string('service');
            $table->string('url');

			$table->timestamps();


            $table->foreign('charity_id')
                ->references('charity_id')
                ->on(Charity::TABLE_NAME)
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(SocialLink::TABLE_NAME);
	}

}
