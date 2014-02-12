<?php

class CharityCategory extends Eloquent {
    const TABLE_NAME = 'charity_categories';

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

    public static function getCategoryId($title) {
        return self::where('title', '=', $title)->get(array('charity_category_id'))->first();
    }

    public static function getTitles() {
        $results = self::distinct()->get();
        $categories = array();
        foreach ($results as $category) {
            $categories[$category->charity_category_id] = $category->title;
        }
        return $categories;
    }

}
