<?php

class Permission extends Eloquent {
    const TABLE_NAME = 'permissions';

    const ALL_PAGES = 0;
    const CAN_EDIT_PAGE = 1;
    const CAN_POST = 1;

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

    public function charity() {
        return $this->belongsTo('Charity', 'charity_id');
    }

    /**
     * 
     */
    public static function make(User $user, Charity $charity, $page, $level) {
        $permission = new Permission();
        $permission->user_id = $user->user_id;
        $permission->charity_id = $charity->charity_id;
        $permission->page_id = $page == null ? 0 : $page->page_id;
        $permission->level = $level;

        return $permission;
    }

    public function user() {
        return $this->belongsTo('User', 'user_id');
    }

}
