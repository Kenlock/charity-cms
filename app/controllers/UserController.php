<?php

use \Cms\App\Sanitiser;

class UserController extends BaseController {

    protected $layout = 'layout._single_column';

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array(
            'only' => array(
                'getDashboard'
            )
        ));
    }

    public function getAll() {
        $users = User::limit(25)->get();
        $this->layout->content = View::make('users.all');
        $this->layout->content->users = $users;
        $this->layout->content->oauth = OAuth::get();
    }

    public function getDashboard() {
        $favorites = Favorite::with('charity')
            ->where('user_id', '=', Auth::user()->user_id)
            ->limit(10)
            ->get();
        $favoriteCharities = array();
        foreach ($favorites as $fav) {
            $favoriteCharities[] = $fav->charity;
        }

        $comments = Comment::with('post')
            ->where('user_id', '=', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return View::make('layout._two_column', array(
            'content' => View::make('users.dashboard', array(
                'myFavoriteCharities' => $favoriteCharities,
                'my_recent_comments' => $comments,
            ))
        ));
    }

    public function getLogin() {
        // no need to show a login page if already logged
        if (Auth::check()) {
            return Redirect::to('users/dashboard');
        }

        $this->layout->content = View::make('users.login');
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('users/login')
            ->with('message_success', 'You were successfully logged out');
    }

    public function getRegister() {
        if (Auth::check()) {
            return Redirect::to('users/dashboard')
                ->with('message_error', 'You already have an account!');
        }

        $this->layout->content = View::make('users.register');
    }

    public function postCreate() {
        $user = User::makeFromArray(Input::all());

        if ($user->isValid()) {
            $user->save();

            return Redirect::to('users/login')
                ->with('message_success', Lang::get('forms.register_success'));
        } else {
            return Redirect::to('users/register')
                ->with('message_error', Lang::get('forms.errors_occurred'))
                ->withErrors($user->getValidator())
                ->withInput();
        }
    }

    public function postSignin() {
        if (Auth::attempt(array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
                ))) {
            return Redirect::to('users/dashboard')
                ->with('message_success', Lang::get('strings.login_successful'));
        } else {
            return Redirect::to('users/login')
                ->with('message_error', Lang::get('strings.login_failed'))
                ->withInput();
        }
    }

}
