<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
    const TABLE_NAME = 'users';

    public static $rules = array(
        'firstname'             =>'required|between:2,50',
        'lastname'              =>'required|between:2,50',
        'email'                 =>'required|email|unique:users',
        'password'              =>'required|alpha_num|between:6,20|confirmed',
        'password_confirmation' =>'required|alpha_num|between:6,20'
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

    protected $guarded = array('id', 'password');
    protected $fillable = array('description', 'firstname', 'lastname', 'image', 'email');

    public function canCreatePage(Charity $charity) {
        $permissions = Permission::where('user_id', '=', $this->user_id)
            ->where('charity_id', '=', $charity->charity_id)
            ->where('level', '=', Permission::CAN_EDIT_PAGE)
            ->get();
        return $permissions != null;
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

	/**
	 * Get the user's image/logo/avatar
	 *
	 * @return string URL to image
	 */
	public function getImage()
	{
		return $this->image;
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

    /**
     * Create a User from the given attributes.
     * Note: this fills a new object with the given attributes and defines
     *      unfilleable attributes explicitly
     * @param array $attributes the attributes to create a User from
     * @return User the new User
     */
    public static function make($attributes) {
        $user = new User();
        $user->fill($attributes);
        $user->password = Hash::make($attributes['password']);
        return $user;
    }

    public function permissions() {
        return $this->hasMany('Permission');
    }

    /**
     * Validate an array of attributes using this model's rules.
     * @param array $data the attributes to validate
     * @return Validator the Validator containing the validation result
     */
    public static function validate($data) {
        return Validator::make($data, self::$rules);
    }

}
