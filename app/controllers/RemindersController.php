<?php

class RemindersController extends BaseController {
    protected $layout = 'layout._single_column';

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind() {
		$this->layout->content = View::make('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind() {
        $response = Password::remind(Input::only('email'), function ($message) {
            $message->subject('Password Reset');
        });

		switch ($response) {
			case Password::INVALID_USER:
				return Redirect::back()->with('message_error', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('message_success', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null) {
		if (is_null($token)) App::abort(404);

		$this->layout->content = View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset() {
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password) {
			$user->password = $password;

			$user->save();
		});

		switch ($response) {
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('message_error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('users/login')
                    ->with('message_success', 'Your password has been reset');
		}
	}

}
