<?php

class CharityStyle extends Eloquent {

    const TABLE_NAME = 'charity_styles';

    protected $fillable = array(
        'charity_id', 'property', 'value'
    );

    protected $primaryKey = 'id';

    public function charity() {
        return $this->belongsTo('Charity', 'charity_id', 'charity_id');
    }

}
