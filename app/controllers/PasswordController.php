<?php

class PasswordController extends BaseController {
    protected $layout = 'layout._single_column';

    /**
     * Show the request password reminder form
     */
    public function remind() {
        $this->layout->content = View::make('password.remind');
    }

    /**
     * Send a reminder token to the given email
     */
    public function request() {
        $data = array(
            'email' => Input::get('email')
        );
        return Password::remind($data);
    }

    /**
     * Show the password reset form
     * @param string $token the reminder token
     */
    public function reset($token) {
        $this->layout->content = View::make('password.reset')
            ->with('token', $token);
    }

    /**
     * Reset the user's password and redirect them to the login page to try
     * out their new password
     * @param string $token the reminder token
     */
    public function update($token) {
        $credentials = array(
            'email' => Input::get('email')
        );

        // get the user validation rules, and apply relevant ones
        $user = new User();
        $rules = $user->getValidationRules();
        $validator = Validator::make(Input::all(), array(
            'email' => $rules['email'],
            'password' => $rules['password']
        ));

        if (!$validator->passes()) return Redirect::back()
                ->withInput()
                ->withErrors($validator);
         
        return Password::reset($credentials, function($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
         
            return Redirect::to('users/login')
                ->with('message_success', 'Your password has been reset');
        });
    }

}
