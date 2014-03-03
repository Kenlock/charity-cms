<?php

class Favorite extends Eloquent {
    const TABLE_NAME = 'favorites';

    public function charity() {
        return $this->hasOne('Charity', 'charity_id', 'charity_id');
    }

    public function user() {
        return $this->hasOne('User', 'user_id', 'user_id');
    }

}
