<?php

class Client extends \Eloquent {
	protected $fillable = [];

	public static $rules=array();


	public function package(){
		return $this->belongsTo('Package','package_id');
	}

	public function roles(){
		return $this->hasMany('Role');
	}

	public function permissions(){
		return $this->hasMany('Permission');
	}

	public function users(){
		return $this->hasMany('User');
	}

	public function warehouses(){
		return $this->hasMany('Warehouses');
	}

	public function customers(){
		return $this->hasMany('Customer');
	}

	public function customersGroups(){
		return $this->hasMany('CustomerGroup');
	}

	public function ReportPhysical(){
		return $this->hasMany('ReportPhysicalStocktaking','client_id');
	}

	public function ReportAdjust(){
		return $this->hasMany('ReportAdjustStock','client_id');
	}
}