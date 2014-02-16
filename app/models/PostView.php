<?php

class PostView extends Eloquent {
    const TABLE_NAME = 'post_views';


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

    protected $primaryKey = 'post_view_id';

    public static function getViewTitles() {
        $postViews = self::get();
        $titles = array();
        foreach ($postViews as $postView) {
            $titles[$postView->post_view_id] = $postView->title;
        }
        return $titles;
    }

}
