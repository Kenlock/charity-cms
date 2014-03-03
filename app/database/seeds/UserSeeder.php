<?php

class UserSeeder extends Seeder {

    public function run() {
        DB::table(User::TABLE_NAME)->delete();
        
        User::makeFromArray(array(
            'firstname' => 'Aidan',
            'lastname'  => 'Grabe',
            'email'     => 'aidsgrabe@gmail.com',
            'password'  => 'password',
            'description' => 'Hello',
            'image' => ''
        ))->save();
    }

}
