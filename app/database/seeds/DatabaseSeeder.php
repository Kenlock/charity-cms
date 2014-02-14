<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        // create the Charity Categories
		$this->call('CharityCategorySeeder');

        // create the FormViews
		$this->call('PostViewSeeder');
	}

}
