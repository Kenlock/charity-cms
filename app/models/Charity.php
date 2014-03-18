<?php

use observers\CharityObserver;

use Cms\App\Path;
use Cms\App\Styles;

class Charity extends BaseModel {
    const TABLE_NAME = 'charities';

    protected $primaryKey = 'charity_id';

    protected $rules = array(
        'address'           => 'required|min:6',
        'description'       => 'required|min:2',
        'name'              => "required|min:2|unique:charities",
        'email'              => "required|email",
        'charity_no'              => "required|integer|digits_between:2,12",
        'charity_category_id'  => 'required|exists:charity_categories,charity_category_id',
        'image'             => 'sometimes|image|max:4096'
    );

    protected $updateRules = array(
        'name'              => ':same:,name,:id:'
    );

    protected $presenter = 'presenters\CharityPresenter';

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
    protected $fillable = array(
         'charity_category_id', 'charity_no', 'email', 
         'name', 'description', 'address'
    );

    /**
     * Register the charity observer on boot
     */
    public static function boot() {
        parent::boot();
        
        static::observe(new CharityObserver());
    }

    public function category() {
        return $this->hasOne('CharityCategory', 'charity_category_id', 'charity_category_id');
    }

    public function favorites() {
        return $this->hasMany('Favorite', 'charity_id', 'charity_id');
    }

    /**
     * Analogous to Charity::find($id) but uses the Charity's name column as a
     * primary key
     * @param string $name the name to lookup
     * @throws ModelNotFoundException
     * @return Charity
     */
    public static function findByName($name) {
        $charity = Charity::where('name', '=', $name)
            ->first();
        if ($charity == null) throw new ModelNotFoundException(get_called_class());
        return $charity;
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

    public function getFavoriteCount() {
        return Favorite::where('charity_id', '=', $this->charity_id)->count();
    }

    /**
     * Get the currently popular charities, based on heart-count
     * @param int $num the number of charities to show
     * @return Collection of Charities with an extra attribute called
     *      'num_favorites'
     */
    public static function getPopular($num) {
        $t1 = static::TABLE_NAME;
        $t2 = Favorite::TABLE_NAME;
        $result = Charity::join($t2, "{$t2}.charity_id", '=', "{$t1}.charity_id")
            ->select(DB::raw("count(*) AS num_favorites, {$t2}.charity_id, name"))
            ->groupBy("{$t2}.charity_id")
            ->orderBy('num_favorites', 'DESC')
            ->limit($num)
            ->get();
        return $result;
    }

    public function getNameAttribute() {
        return e($this->attributes['name']);
    }

    public function getStyles() {
        return new Styles($this->styles);
    }

    /**
     * Make a charity and save it in the Database
     * @deprecated
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

    /**
     * Create an address from multiple strings
     * @param string $line... each line of the address
     * @return string each line separated by a ',' (comma)
     */
    public static function makeAddress() {
        $args = func_get_args();
        foreach ($args as $index => $arg) {
            $args[$index] = str_replace(',', '', $arg);
        }
        return implode(',', $args);
    }

    public function pages() {
        return $this->hasMany('Page', 'charity_id', 'charity_id');
    }

    public function permissions() {
        return $this->hasMany('Permission', 'charity_id', 'charity_id');
    }

    public function socialLinks() {
        return $this->hasMany('SocialLink', 'charity_id', 'charity_id');
    }

    public function styles() {
        return $this->hasMany('CharityStyle', 'charity_id', 'charity_id');
    }

}
