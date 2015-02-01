<?php

class Permission extends BaseModel {
	protected $fillable = ['role_id','client_id','type','action','resource'];

	const ALLOW = 'allow';
	const DENY = 'deny';
	static $rules=array(
		'role_id'=>'required',
		'client_id'=>'required',
		'type'=>'required',
		'action'=>'required',
		'resource'=>'required',
	);

	public function role(){
		return $this->belongsTo('Role');
	}

	public function resources(){
		return $this->belongsTo('Resource','resource');
	}

	public function client(){
		return $this->belongsTo('Client');
	}
}