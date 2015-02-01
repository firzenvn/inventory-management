<?php

class RoleUser extends \Eloquent {
	protected $fillable = [];
	protected $table='role_user';

	public function role(){
		return $this->belongsTo('Role','role_id','id');
	}
}