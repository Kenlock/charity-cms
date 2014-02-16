<?php

class Post extends Eloquent {
    const TABLE_NAME = 'posts';

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

    protected $guarded = array();
    protected $fillable = array();
    
    protected $primaryKey = 'post_id';

    public function getLargeProperty($key) {
        foreach ($this->propertiesLarge as $prop) {
            if ($prop->title == $key) return $prop->content;
        }
        return '';
    }

    public function getProperty($key) {
        $property = $this->getSmallProperty($key);
        return $property == '' ? $this->getLargeProperty($key) : $property;
    }

    public function getSmallProperty($key) {
        foreach ($this->propertiesSmall as $prop) {
            if ($prop->title == $key) return $prop->content;
        }
        return '';
    }

    public function propertiesSmall() {
        return $this->hasMany('PostPropertySmall');
    }

    public function propertiesLarge() {
        return $this->hasMany('PostPropertyLarge');
    }

    public function postView() {
        return $this->hasOne('PostView', 'post_view_id');
    }

}
