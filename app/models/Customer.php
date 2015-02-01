<?php

class Customer extends \Eloquent {
	protected $fillable = ['client_id','customer_group_id','first_name','last_name','middle','prefix','email','phone_no','fax','dob','vat_number','gender','zipcode','city','country_id','province_id','password','company','address'];

	public static $rules=array(
		'email'=>'required|email|unique:customers',
		'phone_no'=>'required|unique:customers',
		'fax'=>'required|unique:customers',
		'vat_number'=>'required|unique:customers',
	);

	public function mysave(){
		return parent::save();
	}

	public function country(){
		return $this->belongsTo('Country','country_id','id');
	}

	public function group(){
		return $this->belongsTo('CustomerGroup','customer_group_id','id');
	}
}