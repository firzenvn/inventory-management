<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 06/11/2014
 * Time: 10:45 SA
 */
class ShipmentItem extends BaseModel{
	protected $fillable = ['shipments_id','client_id','product_id','qty_add','sub_total'];

	public static $rules=array(
		'product_id'=>'required',
		'qty_add'=>'required',
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

	public function shipment(){
		return $this->belongsTo('Shipment');
	}

	public function product(){
		return $this->belongsTo('Product');
	}
}