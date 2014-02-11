<?php

use \Cms\App\Messages\FlashMessageFactory;
use \Cms\App\Strings;

class UserController extends BaseController {

    protected $layout = 'layout._single_column';

    public function __construct() {
        $this->beforeFilter('csrf', ['on' => 'post']);
        $this->beforeFilter('auth', ['only' => ['getDashboard']]);
    }

    public function getAll() {
        $users = User::where('firstname',  'Aidan')->get();
        $this->layout->content = View::make('users.all');
        $this->layout->content->users = $users;
        $this->layout->content->oauth = OAuth::get();
    }

    public function getDashboard() {
        $this->layout->content = View::make('users.dashboard');
    }

    public function getLogin() {
        // no need to show a login page if already logged
        if (Auth::check()) {
            return Redirect::to('users/dashboard');
        }

        $this->layout->content = View::make('users.login');
    }

    public function getRegister() {
        $this->layout->content = View::make('users.register');
    }

    public function postCreate() {
        $validator = User::validate(Input::all());

        if ($validator->passes()) {
            // make a new user from the input received
            $user = User::make(Input::all());
            $user->save();

            $msg = FlashMessageFactory::makeSuccessMessage(Lang::get('strings.register_success'));

            return Redirect::to('users/login')
                ->with('message', $msg);
        } else {
            $msg = FlashMessageFactory::makeWarningMessage(Lang::get('strings.register_error'));
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
            $msg = FlashMessageFactory::makeSuccessMessage(Lang::get('strings.login_successful'));
            return Redirect::to('users/dashboard')->with('message', $msg);
        } else {
            $msg = FlashMessageFactory::makeWarningMessage(Lang::get('strings.login_failed'));
            return Redirect::to('users/login')
                ->with('message', $msg)
                ->withInput();
        }
    }

}
