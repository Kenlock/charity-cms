<?php

class Charity extends Eloquent {
    const TABLE_NAME = 'charities';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = self::TABLE_NAME;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    protected $guarded = array('charity_id', 'name');
    protected $fillable = array();
}
