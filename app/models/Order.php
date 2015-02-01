<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:45 SA
 */
class Order extends BaseModel{
	protected $fillable = [];

	public static $rules=array(
		'bill_customer_id'=>'required',
		'ship_customer_id'=>'required',
		'base_grand_total'=>'required',
		'purchased_grand_total'=>'required|numeric',
		'status'=>'required',
	);

	public static $create_rules=array(
		'bill_customer_id'=>'required',
		'ship_customer_id'=>'required',
		'search_customer'=>'required|numeric',
	);
	const ORDER_PENDING = 'pending';
	const ORDER_PROCESSING = 'processing';
	const ORDER_COMPLETE = 'complete';
	const ORDER_CANCELED = 'canceled';

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

	public function customer(){
		return $this->belongsTo('Customer','bill_customer_id');
	}

	public function orderItem(){
		return $this->hasMany('OrderItem');
	}

	public function invoice(){
		return $this->hasMany('Invoice');
	}

	public function shipment(){
		return $this->hasMany('Shipment');
	}
}