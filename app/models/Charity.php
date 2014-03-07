<?php

use observers\CharityObserver;

use Cms\App\Path;

class Charity extends Eloquent {
    const DEFAULT_IMAGE = 'css/images/user_default.png';
    const TABLE_NAME = 'charities';

    protected $primaryKey = 'charity_id';

    public static $rules = array(
        'address'           => 'required|min:6',
        'description'       => 'required|min:2',
        'name'              => "required|min:2|unique:charities",
        'charity_category_id'  => 'required|exists:charity_categories,charity_category_id',
        'image'             => 'sometimes|image|max:4096'
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

    /**
     * Register the charity observer on boot
     */
    public static function boot() {
        parent::boot();
        
        static::observe(new CharityObserver());
    }

    public function getEmailAttribute() {
        return "aidsgrabe@gmail.com";
    }

    public function category() {
        return $this->hasOne('CharityCategory', 'charity_category_id', 'charity_category_id');
    }

    public function favorites() {
        return $this->hasMany('Favorite', 'charity_id', 'charity_id');
    }

    /**
     * Get the administrators belonging to this charity
     * @return Collection of Users
     */
    public function getAdmins() {
        $t1 = User::TABLE_NAME;
        $t2 = Permission::TABLE_NAME;
        return User::leftJoin($t2, "{$t1}.user_id", '=', "{$t2}.user_id")
            ->where('charity_id', '=', $this->charity_id)
            ->where('page_id', '=', Permission::ALL_PAGES)
            ->groupBy("{$t1}.user_id")
            ->get();
    }

    public function getDescriptionAttribute() {
        return Markdown::string($this->attributes['description']);
    }

    public function getFavoriteCount() {
        return Favorite::where('charity_id', '=', $this->charity_id)->count();
    }

    public function getImageAttribute() {
        return $this->attributes['image'] == ''
            ? self::DEFAULT_IMAGE
            : $this->attributes['image'];
    }

    /**
     * Make a charity and save it in the Database
     * TODO[long] convert to ModelObserver method
     */
    public static function makeAndSave($name, $category_id, $description, $address, $image = '') {
        DB::beginTransaction();
        $charity = new Charity();

        if ($image != '') {
            $date = date('d-m-Y');
            $path = Path::make("uploads", $date);
            $movePath = Path::make(public_path(), $path);
            $image->move($movePath, $image->getClientOriginalName());

            $image = Path::make($path, $image->getClientOriginalName());
        }

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

        $page = new Page();
        $page->fill(array(
            'charity_id' => $charity->charity_id,
            'title' => "Home",
            'default_view_id' => Page::DEFAULT_POSTVIEW,
        ));
        $page->save();

        $charity->default_page_id = $page->page_id;
        $charity->update();
        DB::commit();

        return $charity;
    }

    public static function makeAddress() {
        return implode(',', func_get_args());
    }

    public function pages() {
        return $this->hasMany('Page', 'charity_id', 'charity_id');
    }

    public function permissions() {
        return $this->hasMany('Permission', 'charity_id', 'charity_id');
    }

    public static function validate($data) {
        return Validator::make($data, self::$rules);
    }

}
