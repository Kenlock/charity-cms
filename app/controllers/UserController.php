<?php

use \Cms\App\Sanitiser;
use \Cms\App\Validators\UserDeleteValidator;

/**
 * Controller for the User model
 * @author Aidan Grabe
 */
class UserController extends BaseController {

    protected $layout = 'layout._single_column';

    public function __construct() {
        $this->beforeFilter('upload.max', array('on' => 'post'));
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array(
            'only' => array(
                'getDashboard',
                'getDelete',
                'postDelete',
                'getUpdate',
            )
        ));
    }

    /**
     * Show all users
     */
    public function getAll() {
        $users = User::paginate(10);
        $this->layout->content = View::make('users.all', array(
            'users' => $users,
        ));
    }

    /**
     * Show the user's dashboard
     */
    public function getDashboard() {
        $comments = Comment::with('post')
            ->where('user_id', '=', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return View::make('layout._two_column', array(
            'content' => View::make('users.dashboard', array(
                #'favorites' => Auth::user()->getFavoriteCharities(),
                'user'      => Auth::user(),
                'my_recent_comments' => $comments,
            ))
        ));
    }

    /**
     * Show a confirm delete account form. To prevent accidental account
     * deletion
     */
    public function getDelete() {
        return View::make('layout._single_column', array(
            'content'   => View::make('users.delete')
        ));
    }

    /**
     * Show the login form
     */
    public function getLogin() {
        // no need to show a login page if already logged
        if (Auth::check()) {
            return Redirect::to('users/dashboard');
        }

        $this->layout->content = View::make('users.login');
    }

    /**
     * Log the user out
     */
    public function getLogout() {
        Auth::logout();
        return Redirect::to('users/login')
            ->with('message_success', 'You were successfully logged out');
    }

    /**
     * Show the registration form
     */
    public function getRegister() {
        if (Auth::check()) {
            return Redirect::to('users/dashboard')
                ->with('message_error', 'You already have an account!');
        }

        $this->layout->content = View::make('users.register');
    }

    /**
     * Show a form allowing the user to update their account details
     */
    public function getUpdate() {
        $user = Auth::user();

        return View::make('layout._two_column', array(
            'content' => View::make('users.update', array(
                'user' => $user,
            )),
        ));
    }

    /**
     * Create a user from form input
     */
    public function postCreate() {
        $user = User::makeFromArray(Input::all());

        if ($user->isValid()) {
            $user->save();
            try {
                $user->sendRegistrationEmail();
            } catch (Exception $e) {
                Log::error("Error sending registration email: " . $e);
            }

            return Redirect::to('users/login')
                ->with('message_success', Lang::get('forms.register_success'));
        } else {
            return Redirect::to('users/register')
                ->with('message_error', Lang::get('forms.errors_occurred'))
                ->withErrors($user->getValidator())
                ->withInput();
        }
    }

    /**
     * Delete the currently logged in user's account
     */
    public function postDelete() {
        $validator = new UserDeleteValidator(Input::all());

        if ($validator->passes()) {
            Auth::user()->delete();
            return Redirect::to('/')
                ->with('message_success', 'Your account was successfully deleted. '
                        . 'Thank you for using our website.');
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($validator->getValidator())
            ->with('message_error', Lang::get('forms.errors_occurred'));
    }

    /**
     * Try to log the user in
     */
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

    /**
     * Validate an update to the user
     */
    public function postUpdate() {
        $user = Auth::user();
        $user->validateUpdate(Input::all());
        
        if ($user->isValid()) {
            if (Input::hasFile('image')) $user->image = Input::file('image');

            // set the password to plaintext, as the save method will re-hash
            $user->password = Input::has('password')
                ? Input::get('password')
                : Input::get('password_old');
            $user->save();

            return Redirect::back()
                ->with('message_success', "Success!");
        }
        return Redirect::back()
            ->with('message_error', Lang::get('forms.errors_occurred'))
            ->withInput()
            ->withErrors($user->getValidator());
    }

}
