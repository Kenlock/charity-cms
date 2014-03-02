<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cms\App\Sanitiser;

use observers\UserObserver;

class User extends BaseModel implements UserInterface, RemindableInterface {

    const DEFAULT_IMAGE = 'css/images/user_default.png';
    const TABLE_NAME = 'users';

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
    protected $fillable = array('firstname', 'lastname', 'email', 'description', 'image');

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
     * @param Charity $item the item to check
     * @return boolean true if the user can delete the item, false otherwise
     */
    public function canDelete($item) {
        if ($item instanceof Charity) {
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

    public function canPostTo(Page $page) {
        $perms = Permission::where('user_id', '=', $this->user_id)
            ->where('page_id', '=', $page->page_id)->get(array('level'));
        foreach ($perms as $perm) {
            if ($perm->level == Permission::CAN_POST) return true;
        }
        return false;
    }

    public function checkPassword($password) {
        return Hash::check($password, $this->password);
    }

    /**
     * Enable/Disable markdown for this model
     * @param boolean $enabled true will display markdown, false will disable
     *      it
     */
    public function setMarkdown($enabled) {
        $this->markdown = $enabled;
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

    public function getCharities() {
        $t1 = Permission::TABLE_NAME;
        $t2 = Charity::TABLE_NAME;
        return Charity::with('permissions')
            ->leftJoin($t1, "{$t1}.charity_id", '=', "{$t2}.charity_id")
            ->where('user_id', '=', $this->user_id)
            ->groupBy("{$t2}.charity_id")
            ->get();
    }

    public function getDescriptionAttribute() {
        return $this->markdown
            ? Markdown::string($this->attributes['description'])
            : $this->attributes['description'];
    }

    public function getImageAttribute() {
        return $this->attributes['image'] == ''
            ? self::DEFAULT_IMAGE
            : $this->attributes['image'];
    }

    public function getName() {
        return "{$this->firstname} {$this->lastname}";
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
        return $this->hasMany('Permission');
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
