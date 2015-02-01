<?php

class CustomerGroup extends BaseModel {
	protected $fillable = ['name','status','client_id'];

	public static $rule=array(
		'name'=>'required',
		'status'=>'required'
	);

	public static function getGroupToArray(){
		$rs=CustomerGroup::where('client_id', Auth::user()->client_id)->get();
		$data=array(''=>'-- Select one --');
		foreach($rs as $row){
			$data[$row->id]=$row->name;
		}
		return $data;
	}

	public function mysave(){
		CustomerGroup::saving(function($model){
			$validate=Validator::make($model->attributes,self::$rule);
			if(!$validate->passes()){
				$this->errors=$validate->messages();
				return false;
			}
		});
		return parent::save();
	}
}