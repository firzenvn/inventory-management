<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/15/2014
 * Time: 4:03 PM
 */

class Supplier extends BaseModel {
	protected $fillable = [];

	public static $rules=array(
		'name'=>'required',
		'person'=>'required',
		'email'=>'required|email',
		'phone_no'=>'required|numeric',
		'fax'=>'numeric',
		'street'=>'required',
		'city'=>'required',
		'country_id'=>'required|numeric',
		'zipcode'=>'required|numeric',
		'status'=>'required|numeric',
	);

	public static function boot()
	{
		parent::boot();

		// Before saving supplier
		self::saving(function($model)
		{
			if($model->client_id != Auth::user()->client_id)
				throw new \Illuminate\Database\Eloquent\ModelNotFoundException(__CLASS__." not found!",404);
			return $model->validate();
		});

		// Before deleting supplier
		self::deleting(function($model)
		{
			if($model->client_id != Auth::user()->client_id)
				throw new \Illuminate\Database\Eloquent\ModelNotFoundException(__CLASS__." not found!",404);
		});
	}

	public function client(){
		return $this->belongsTo('Client');
	}

	public function country(){
		return $this->belongsTo('Country');
	}

	public function productSupplierItem(){
		return $this->hasMany('ProductSupplierItem');
	}
} 