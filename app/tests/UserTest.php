<?php

class UserTest extends TestCase {

    public function testCreate() {
        
        $users = array(
            array(
                'valid' => true,
                'firstname' => 'Aidan',
                'lastname' => 'Grabe',
                'password' => 'password',
                'password_confirmation' => 'password',
                'email' => 'aidsgrabe5@gmail.com',
                'description' => 'This is my description',
                'image' => '',
            ),
            array(
                'valid' => false,
                'firstname' => 'Aidan',
                'lastname' => 'Grabe',
                'password' => 'po',
                'password_confirmation' => 'po',
                'email' => 'aidsgrabe5@gmail.com',
                'description' => 'This is my description',
                'image' => '',
            ),
        );

        foreach ($users as $user) {
            $u = User::makeFromArray($user);
            $this->assertEquals($u->isValid(), $user['valid']);
            $u->delete();
        }

    }

}
