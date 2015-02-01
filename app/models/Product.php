<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 11/14/2014
 * Time: 9:30 PM
 */

class Product extends BaseModel {
	public static $rules=array(
		'name'=>'required',
		'sku'=>'required',
		'price'=>'required|numeric',
		'quantity'=>'required|numeric',
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
} 