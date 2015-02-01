<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:45 SA
 */
class Invoice extends BaseModel{
	protected $fillable = [];

	public static $rules=array(
		'order_id'=>'required',
	);

	const ACTIVE = 1;
	const INACTIVE = 0;
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

	public function order(){
		return $this->belongsTo('Order');
	}

	public function invoiceItem(){
		return $this->hasMany('InvoiceItem');
	}
}