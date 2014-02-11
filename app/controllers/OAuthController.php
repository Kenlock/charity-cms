<?php

use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

class OAuthController extends BaseController {

    private function redirectDashboard($message = true) {
        return Redirect::to('users/dashboard')
            ->with('message', $message ? Lang::get('strings.login_successful') : '');
    }

    public function getOAuth($providerName) {
        if (Auth::check()) {
            return $this->redirectDashboard(false);
        }

        $providerKeys = Config::get("oauth.{$providerName}");

        if ($providerKeys == "") {
            return "Unknown provider.";
        }

        $provider = OAuth2::provider($providerName, $providerKeys);

        if (!Input::get('code')) {
            return $provider->authorize();
        } else {
            try {
                $params = $provider->access(Input::get('code'));
                $token = new Token_Access(array(
                    'access_token' => $params->access_token
                ));
                $oauthUser = $provider->get_user_info($token);
            } catch (OAuth2_Exception $e) {
                return "Oops! {$e}";
            }

            $existingUser = OAuth::where('uid', '=', $oauthUser['uid'])
                ->where('provider', '=', $providerName)
                ->first();

            if ($existingUser == null) {
                $user = User::where('email', '=', $oauthUser['email'])->first();
                if ($user == null) {
                    // register new user
                    $userAttributes = array(
                        'firstname' => $oauthUser['first_name'],
                        'lastname' => $oauthUser['last_name'],
                        'email' => $oauthUser['email'],
                        'image' => $oauthUser['image'],
                        'description' => $oauthUser['description'],
                        'password' => User::generateRandomPassword(10)
                    );
                    $user = User::make($userAttributes);
                    $user->save();
                }

                $oauthEntry = new OAuth();
                $oauthEntry->uid = $oauthUser['uid'];
                $oauthEntry->provider = $providerName;
                $oauthEntry->user_id = $user->user_id;

                Auth::login($user);

                return $this->redirectDashboard();
                //return Redirect::to('users/dashboard');
            } else {
                Auth::login(User::find($existsingUser->user_id));
                return $this->redirectDashboard();
            }
            //var_dump($user);
            /**
             *  $user->uid
             *  $user->name
             *  $user->first_name
             *  $user->last_name
             *  $user->email
             *  $user->image
             *  $user->description
             */
        }
    }

}
