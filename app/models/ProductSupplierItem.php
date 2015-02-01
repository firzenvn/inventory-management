<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:45 SA
 */
class ProductSupplierItem extends BaseModel{
	protected $fillable = ['supplier_id','client_id','product_id','cost','tax','discount','supplier_sku'];

	public static $rules=array(
		'product_id'=>'required',
		'supplier_id'=>'required',
	);

	public static function boot()
	{
		parent::boot();

		// Before saving warehouse
		self::saving(function($model)
		{
			if($model->client_id != Auth::user()->client_id)
				throw new \Illuminate\Database\Eloquent\ModelNotFoundException(__CLASS__." not found!",404);
			return $model->validate();
		});

		// Before deleting warehouse
		self::deleting(function($model)
		{
			if($model->client_id != Auth::user()->client_id)
				throw new \Illuminate\Database\Eloquent\ModelNotFoundException(__CLASS__." not found!",404);
		});
	}

	public function client(){
		return $this->belongsTo('Client');
	}

	public function supplier(){
		return $this->belongsTo('Supplier');
	}

	public function product(){
		return $this->belongsTo('Product');
	}
}