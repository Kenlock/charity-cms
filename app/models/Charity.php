<?php

class Charity extends Eloquent {
    const TABLE_NAME = 'charities';

    protected $primaryKey = 'charity_id';

    public static $rules = array(
        'address'           => 'required|min:6',
        'description'       => 'required|min:2',
        'name'              => "required|min:2|unique:charities",
        'charity_category_id'  => 'required|exists:charity_categories,charity_category_id'
    );

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

    protected $guarded = array('charity_id');
    protected $fillable = array();

    public function category() {
        return $this->hasOne('CharityCategory', 'charity_category_id');
    }

    #public static function make($data) {
    #    $charity = new Charity();
    #    $charity->fill($data);
    #    return $charity;
    #}

    public static function makeAndSave($name, $category_id, $description, $address, $image = '') {
        DB::beginTransaction();
        $charity = new Charity();
        $charity->fill(array(
            'name' => $name,
            'charity_category_id' => $category_id,
            'description' => $description,
            'default_page_id' => 0,
            'address' => $address,
            'image' => $image
        ));
        $charity->save();

        $permission = Permission::make(Auth::user(), $charity, Permission::ALL_PAGES, 1);
        $permission->save();

        $page = Page::makeAndSave(Auth::user(), $charity, array(
            'charity_id' => $charity->charity_id,
            'title' => "Home",
            'default_view_id' => 0,
        ));

        $charity->default_page_id = $page->page_id;
        $charity->update();
        DB::commit();

        return $charity;
    }

    public static function makeAddress() {
        return implode(',', func_get_args());
    }

    public function permissions() {
        return $this->hasMany('Permission');
    }

    public static function validate($data) {
        return Validator::make($data, self::$rules);
    }

}
