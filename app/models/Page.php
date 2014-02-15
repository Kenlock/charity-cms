<?php

class Page extends Eloquent {
    const TABLE_NAME = 'pages';

    public static $rules = array(
        'title' => 'required|between:2,40',
        'charity_id' => 'required|integer|exists:charities,charity_id',
        'default_view_id' => 'required|integer|exists:post_views,post_view_id',
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
    protected $fillable = array('title', 'charity_id', 'default_view_id');

    public static function makeAndSave(User $user, Charity $charity, $data) {
        $page = new Page();
        $page->fill($data);
        DB::beginTransaction();
        $page->page_id = $page->save();
        $perm = Permission::make($user, $charity, $page, Permission::CAN_EDIT_PAGE);
        $perm->save();
        DB::commit();
        return $page;
    }

    public static function validate($data) {
        return Validator::make($data, self::$rules);
    }
}
