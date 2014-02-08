<?php

use \Cms\App\FlashMessage;
use \Cms\App\Strings;

class UserController extends BaseController {

    protected $layout = 'layout.message-layout';

    public function __construct() {
        $this->beforeFilter('csrf', ['on' => 'post']);
        $this->beforeFilter('auth', ['only' => ['getDashboard']]);
    }

    public function getDashboard() {
        $this->layout->content = View::make('users.dashboard');
    }

    public function getLogin() {
        if (Auth::check()) {
            echo "Logged in";
        }
        $this->layout->content = View::make('users.login');
    }

    public function getRegister() {
        $this->layout->content = View::make('users.register');
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->passes()) {
            // save the user
            $user = new User();
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->description = Input::get('description');
            $user->password = Hash::make(Input::get('password'));
            $user->image = "";
            $user->save();

            $msg = FlashMessageFactory::makeSuccessMessage(Strings::get('register_success'));

            return Redirect::to('users/login')
                ->with('message', $msg);
        } else {
            $msg = FlashMessageFactory::makeWarningMessage(Strings::get('register_error'));
            return Redirect::to('users/register')
                ->with('message', $msg)
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function postSignin() {
        if (Auth::attempt([
                'email' => Input::get('email'),
                'password' => Input::get('password')
                ])) {
            $msg = FlashMessageFactory::makeSuccessMessage(Strings::get('login_successful'));
            return Redirect::to('users/dashboard')->with('message', $msg);
        } else {
            $msg = FlashMessageFactory::makeWarningMessage(Strings::get('login_failed'));
            return Redirect::to('users/login')
                ->with('message', $msg)
                ->withInput();
        }
    }

}
