<?php namespace observers;

class UserObserver {

    #public function deleting($user) {
    #    DB::beginTransaction();
    #    $charities = $user->getCharities();
    #}

    #public function deleted($user) {
    #    DB::commit();
    #}

    public function saving($user) {
        $user->image = $user->saveImage($user->image);
        $user->password = $user->makePassword($user->password);
    }

}
