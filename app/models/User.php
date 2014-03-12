<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cms\App\Sanitiser;

use observers\UserObserver;
use presenters\Presentable;

class User extends BaseModel implements Presentable, UserInterface,
        RemindableInterface {
    const TABLE_NAME = 'users';

    protected $presenter = 'presenters\UserPresenter';

    protected $rules = array(
        'firstname'             =>'required|between:2,50',
        'lastname'              =>'required|between:2,50',
        'email'                 =>'required|email|unique:users',
        'image'                 =>'sometimes|image|max:4096',
        'password'              =>'required|between:6,20|confirmed',
        'password_confirmation' =>'required|between:6,20'
    );

    protected $updateRules = array(
        'email'                 =>':same:,email,:id:',
        'password_old'          =>'required|password_match',
        'password'              =>'sometimes|between:6,20|confirmed',
        'password_confirmation' =>'sometimes|between:6,20',
    );

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = self::TABLE_NAME;
	protected $primaryKey = 'user_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    protected $guarded = array('password');
    protected $fillable = array('firstname', 'lastname', 'email', 'description');

    private $markdown = true;

    /**
     * Register the user observer on boot
     */
    public static function boot() {
        parent::boot();
        
        static::observe(new UserObserver());
    }

    public function canCreatePage(Charity $charity) {
        $permissions = Permission::where('user_id', '=', $this->user_id)
            ->where('charity_id', '=', $charity->charity_id)
            ->where('level', '=', Permission::CAN_EDIT_PAGE)
            ->get();
        return $permissions != null;
    }

    /**
     * Check if the current user has permission to delete a given item
     * @param Charity|Comment|Page $item the item to check
     * @return boolean true if the user can delete the item, false otherwise
     */
    public function canDelete($item) {
        if ($item instanceof Charity || $item instanceof Page) {
            return Permission::where('user_id', '=', $this->user_id)
                ->where('charity_id', '=', $item->charity_id)
                ->where('page_id', '=', Permission::ALL_PAGES)
                ->count() > 0;
        } elseif ($item instanceof Comment) {
            return Comment::where('user_id', '=', $this->user_id)
                ->where('comment_id', '=', $item->comment_id)
                ->count() > 0;
        }
        return false;
    }

    /**
     * Check if the current user can post to a given page
     * @param Page $page the page to check against
     * @return boolean true if the user can post to the given page, otherwise false
     */
    public function canPostTo(Page $page) {
        // if the page is public, return true
        if ($page->open_to_all) return true;

        // check permissions
        return $this->permissions()
            ->where(function($q) use($page) {
                $q->where(function($q) use($page) {
                    $q->where('page_id', '=', $page->page_id)
                    ->where('level', '=', Permission::CAN_POST);
                }) 
                ->orWhere(function($query) use($page) {
                    $query->where('page_id', '=', Permission::ALL_PAGES)
                        ->where('charity_id', '=', $page->charity->charity_id);
                });
            })
            ->count() > 0;
    }

    public function checkPassword($password) {
        return Hash::check($password, $this->password);
    }

    /**
     * Generate a random un-hashed password
     * @param Integer $length the desired length of the password
     * @return String the random password
     */
    public static function generateRandomPassword($length) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        $alphabetLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $password .= $alphabet[rand(0, $alphabetLength)];
        }
        return $password;
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

    /**
     * Get the charities a user is an admin of
     */
    public function getCharities() {
        $t1 = Permission::TABLE_NAME;
        $t2 = Charity::TABLE_NAME;
        return Charity::with('permissions')
            ->leftJoin($t1, "{$t1}.charity_id", '=', "{$t2}.charity_id")
            ->where('user_id', '=', $this->user_id)
            ->groupBy("{$t2}.charity_id")
            ->get();
    }

    public function getFavoriteCharities() {
        $t1 = Charity::TABLE_NAME;
        $t2 = Favorite::TABLE_NAME;

        return Charity::with('favorites')
            ->leftJoin($t2, "{$t1}.charity_id", '=', "{$t2}.charity_id")
            ->where('user_id', '=', $this->user_id)
            ->get();
    }

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public function hasFavorited($charity) {
        return Favorite::where('charity_id', '=', $charity->charity_id)
            ->where('user_id', '=', $this->user_id)
            ->count() > 0;
    }

    /**
     * Check if the current user is an administrator of a given charity
     * @param Charity|int $charity the id of the charity, or the charity model
     *      of the charity to check this user against
     * @return boolean true if the user is an administrator else false
     */
    public function isAdmin($charity) {
        $charity_id = $charity instanceof Charity
            ? $charity->charity_id
            : $charity;
        return $this->permissions()
            ->where('charity_id', '=', $charity_id)
            ->where('page_id', '=', Permission::ALL_PAGES)
            ->count() > 0;
    }

    /**
     * Create a User from the given attributes.
     * @param array $attributes the attributes to create a User from
     * @return User the new User
     */
    public static function makeFromArray(array $attributes) {
        $sanitiser = Sanitiser::make($attributes)
            ->guard(array('image', 'password', 'password_confirmation'))
            ->sanitise();
        $data = $sanitiser->all();

        $user = new User();
        $user->validate($data);

        $user->password = $attributes['password'];
        $user->image = $attributes['image'];

        return $user;
    }

    /**
     * Make a User from the given information
     * @param string $firstname the first name of the user
     * @param string $lastname the second name of the user
     * @param string $email user's email address
     * @param string $password user's desired password
     * @param string $description the user's multi-line description
     * @param UploadedFile $image the user's image
     * @return User the User model instance
     */
    public static function make($firstName, $lastName, $email, $password, $description = '', $image = '') {
        return static::makeFromArray(array(
            'firstname' => $firstName,
            'lastname' => $lastName,
            'email' => $email,
            'description' => $description,
            'image' => $image,
        ));
    }

    public function makePassword($password) {
        return Hash::make($password);
    }

    public function permissions() {
        return $this->hasMany('Permission', 'user_id', 'user_id');
    }

    /**
     * Search for a user by their firstname and lastname combined
     * @param string $search_string the name to be searched for
     * @param int $per_page the number of results per page
     * @return Pagination of User Collection
     */
    public static function searchByName($search_string, $per_page = 10) {
        return User::whereRaw(
            "lower(concat_ws(' ', firstname, lastname)) like lower(?)", array(
                "%{$search_string}%"
            ))
            ->paginate($per_page);
    }

    public function sendRegistrationEmail() {
        $user = $this;
        $data = array(
            'user'  => $user
        );
        Mail::send('emails.auth.register', $data, function($message) use($user) {
                $message->to($user->email, $user->getPresenter()->getName())
                    ->subject('Thank you for registering');
        });
    }

    public function validateUpdate($data) {
        Validator::extend('password_match',
            function($attribute, $value, $parameters) {
                return $this->checkPassword($value);
            }
        );
        parent::validateUpdate($data);

        $messages = array(
            'password_match' => 'Your current password was incorrect',
            'password_old.required' => 'The current password field is required',
        );
        $this->getValidator()->setCustomMessages($messages);
    }

}
