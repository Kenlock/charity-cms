<?php

class Favorite extends Eloquent {

    public function charity() {
        return $this->hasOne('Charity', 'charity_id', 'charity_id');
    }

    public function user() {
        return $this->hasOne('User', 'user_id', 'user_id');
    }

}
