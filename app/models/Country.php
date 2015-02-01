<?php
/**
 * Created by PhpStorm.
 * User: DONY
 * Date: 10/10/2014
 * Time: 9:43 AM
 */

class Country extends Eloquent {
	protected $fillable = [];
	protected $table = 'countries';

	public function warehouse(){
		return $this->hasMany('Warehouse');
	}

	public static function getCountryToArray(){
		$rs=Country::all();
		$data=array(''=>'-- Select one --');
		foreach($rs as $row){
			$data[$row->id]=$row->name;
		}
		return $data;
	}
} 