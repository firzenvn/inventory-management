<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 12/25/2014
 * Time: 12:46 AM
 */

class SendStock extends BaseModel {
	protected $fillable = [];

	public static $rules=array(
	);

	public function client(){
		return $this->belongsTo('Client');
	}

	public function source(){
		return $this->belongsTo('Warehouse','source_warehouse_id','id');
	}

	public function destination(){
		return $this->belongsTo('Warehouse','destination_warehouse_id','id');
	}

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
}