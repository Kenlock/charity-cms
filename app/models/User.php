<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cms\App\Sanitiser;

class User extends BaseModel implements UserInterface, RemindableInterface {
    const TABLE_NAME = 'users';

    protected $rules = array(
        'firstname'             =>'required|between:2,50',
        'lastname'              =>'required|between:2,50',
        'email'                 =>'required|email|unique:users',
        'image'                 =>'sometimes|image|max:4096',
        'password'              =>'required|between:6,20|confirmed',
        'password_confirmation' =>'required|between:6,20'
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

    public function canCreatePage(Charity $charity) {
        $permissions = Permission::where('user_id', '=', $this->user_id)
            ->where('charity_id', '=', $charity->charity_id)
            ->where('level', '=', Permission::CAN_EDIT_PAGE)
            ->get();
        return $permissions != null;
    }

    public function canPostTo(Page $page) {
        $perms = Permission::where('user_id', '=', $this->user_id)
            ->where('page_id', '=', $page->page_id)->get(array('level'));
        foreach ($perms as $perm) {
            if ($perm->level == Permission::CAN_POST) return true;
        }
        return false;
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
        return Markdown::string($this->attributes['description']);
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

    public function permissions() {
        return $this->hasMany('Permission');
    }

    /**
     * Save the current user into the database.
     * This method define's values that cannot be filled using the fill() method
     * @param array $options optional @see Eloquent->save
     */
    public function save(array $options = array()) {
        $this->image = $this->saveImage($this->image);
        $this->password = Hash::make($this->password);

        parent::save($options);
    }

}
