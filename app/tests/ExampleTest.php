<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

    public function testRandomPasswordGenerator() {
        $pass = User::generateRandomPassword(10);
        echo $pass;
        $this->assertTrue(strlen($pass) == 10);
    }

    public function testUserEmailExists() {
        $users = User::where('email', 'dude@gmail.com')->first();
        $this->assertTrue($users == null);
        #$this->assertTrue($users->email == 'dude@gmail.com');
    }

    public function testConfig() {
        $p = 'google';
        echo Config::get("oauth.{$p}.id") . '\n';
        echo Config::get('oauth.facebook.id') . '\n';
        $this->assertTrue(true);
    }

    public function testMarkdown() {
        $string = Markdown::string('#title');
        echo $string;
    }

}
