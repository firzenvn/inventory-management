<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 11/8/2014
 * Time: 8:34 AM
 */

class ProductCategory extends BaseModel {

	protected $table = 'product_category';

	public static $rules=array(
		'product_id'=>'required|numeric',
		'sub_category_id'=>'required|numeric',
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

	public function product(){
		return $this->belongsTo('Product');
	}

	public function sub_category(){
		return $this->belongsTo('SubCategory');
	}
} 