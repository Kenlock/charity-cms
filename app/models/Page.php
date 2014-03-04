<?php

use observers\PageObserver;

class Page extends BaseModel {
    const TABLE_NAME = 'pages';

    const DEFAULT_POSTVIEW = 1;

    protected $rules = array(
        'title'             => 'required|between:2,40',
        'charity_id'        => 'required|integer|exists:charities,charity_id',
        'default_view_id'   => 'required|integer|exists:post_views,post_view_id',
        'open_to_all'       => 'sometimes|integer|accepted',
    );

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = self::TABLE_NAME;
	protected $primaryKey = 'page_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    protected $guarded = array();
    protected $fillable = array(
        'title', 'charity_id', 'default_view_id', 'open_to_all'
    );

    /**
     * Register the Page observer on boot
     */
    public static function boot() {
        parent::boot();
        
        static::observe(new PageObserver());
    }

    public function charity() {
        return $this->hasOne('Charity', 'charity_id', 'charity_id');
    }

    public function posts() {
        return $this->hasMany('Post', 'page_id', 'page_id');
    }
}
