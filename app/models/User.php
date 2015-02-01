<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $fillable = ['username','first_name','last_name','email','company_name','website_url','phone','client_id','oauth2_id','password','client_order'];

	public $errors='';
	public $isNewRecord=0;


	const USER_PACKAGE_TRIAL = 1;
	public static $rules = array(
		'username'=>'required|min:6|max:45|alpha_num|unique:users',
		'first_name'=>'min:2',
		'last_name'=>'min:2',
		'email'=>'email|unique:users',
		'company_name'=>'min:3',
		'website_url'=>'url',
		'phone'=>'regex:/^[0-9]{9,13}$/|unique:users',
		'password'=>'required|alpha_num|min:6|max:12|confirmed',
		'password_confirmation'=>'required|alpha_num|min:6|max:12'
	);

	public static $rules_client_user = array(
		'username'=>'required|min:6|max:45|alpha_num',
		'first_name'=>'min:2',
		'last_name'=>'min:2',
		'email'=>'email|unique:users',
		'phone'=>'regex:/^[0-9]{9,13}$/|unique:users',
		'password'=>'required|alpha_num|min:6|max:12',
	);

	public static $rules_update_user = array(
		'first_name'=>'min:2',
		'last_name'=>'min:2',
		'email'=>'email|unique:users',
		'phone'=>'regex:/^[0-9]{9,13}$/|unique:users',
		'password'=>'alpha_num|min:6|max:12',
	);

	public static $rules_change_password = array(
		'password'=>'required|alpha_num|min:6|max:12',
		'new_password'=>'required|alpha_num|min:6|max:12|confirmed',
		'new_password_confirmation'=>'required|alpha_num|min:6|max:12'
	);

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function mysave(){
		if(isset(Auth::user()->client_id)){
			$user=User::where('username','=',$this->username)->where('client_id','=',Auth::user()->client_id)->first();
			if(!empty($user)){
				$this->errors=Lang::get('users.duplicate_username_client_id');
				return false;
			}
		}
		return parent::save();
	}

	public function myupdate($data){
		$user=User::find($this->id);
		if($user->username!=$this->username){
			$user=User::where('username','=',$this->username)->where('client_id','=',Auth::user()->client_id)->first();
			if(!empty($user)){
				$this->errors=Lang::get('users.duplicate_username_client_id');
				return false;
			}
		}
		return parent::update($data);
	}

	public function roles() {
		return $this->belongsToMany('Role');
	}

	public function roleUser(){
		return $this->belongsTo('RoleUser','id','user_id');
	}

	public function hasRole($key)
	{
		foreach ($this->roles as $role) {
			if ($role->role_name === $key) {
				return true;
			}
		}
		return false;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}
