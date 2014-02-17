<?php

class UserSeeder extends Seeder {

    public function run() {
        DB::table(User::TABLE_NAME)->delete();
        

    }

}
