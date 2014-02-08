<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
    const TABLE_NAME = 'users';
    public static $rules = array(
        'firstname'             =>'required|alpha|min:2',
        'lastname'              =>'required|alpha|min:2',
        'email'                 =>'required|email|unique:users',
        'description'           =>'required',
        'password'              =>'required|alpha_num|between:6,12|confirmed',
        'password_confirmation' =>'required|alpha_num|between:6,12'
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

}
