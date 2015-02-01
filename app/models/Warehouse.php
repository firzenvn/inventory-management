<?php

class Warehouse extends BaseModel {
	protected $fillable = [];

	public static $rules=array(
		'name'=>'required',
		'manager_name'=>'required',
		'manager_email'=>'required|email',
		'phone_no'=>'required|numeric',
		'street'=>'required',
		'city'=>'required',
		'country_id'=>'required|numeric',
		'zipcode'=>'required|numeric',
		'status'=>'required|numeric',
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

	public function country(){
		return $this->belongsTo('Country');
	}

	public static function getWarehouseToArray(){
		$rs=Warehouse::where('client_id','=',Auth::user()->client_id)->get();
		$data=array(''=>'-- Select one --');
		if(!empty($rs))
			foreach($rs as $row)
				$data[$row->id]=$row->name;
		return $data;
	}
} 