<?php namespace observers;

class UserObserver {

    public function saving($user) {
        $user->image = $user->saveImage($user->image);
        $user->password = $user->makePassword($user->password);
    }

}
