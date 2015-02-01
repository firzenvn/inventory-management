<?php

class Role extends BaseModel {
	protected $fillable = ['inherited_roleid','role_name','client_id'];

	public static $rules=array(
		'role_name'=>'required',
	);

	public function permissions() {
		return $this->hasMany('Permission');
	}

	public function parentRole(){
		return $this->belongsTo('Role','inherited_roleid','id');
	}

	public function client(){
		return $this->belongsTo('Client');
	}

	public static function getRolesClientToArray($ignore=null,$filler_rule=false){
		$rs=Role::where('client_id', Auth::user()->client_id)->get();
		$data=array(''=>'= Select one =');
		foreach($rs as $row){
			if($row->id==$ignore)
				continue;
			if($filler_rule && is_null($row->inherited_roleid))
				$data[$row->id]=$row->role_name;
			if($filler_rule==false)
				$data[$row->id]=$row->role_name;
		}
		return $data;
	}

	public function mysave(){
		Role::saving(function($model){
			$validate=Validator::make($model->attributes,self::$rules);
			if(!$validate->passes())
				$this->errors=$validate->messages();
			return false;
		});
		return parent::save();
	}
	public function myupdate($input){
		Role::saving(function($model,$input){
			$validate=Validator::make($model->attributes,self::$rules);
			if(!$validate->passes())
				$this->errors=$validate->messages();
			return false;
		});
		return parent::save();
	}

	public static function boot()
	{
		parent::boot();

		Role::saving(function($model)
		{
			$details='CHANGED DETAILS: <br/>';
			foreach($model->getDirty() as $attribute => $value){
				$original= $model->getOriginal($attribute);
				$details.="$attribute: '$original' => '$value'<br/>";
			}
			Activity::log(array(
				'contentID'   => $model->id,
				'contentType' => __CLASS__,
				'description' => 'Thêm/Cập nhật  một '.__CLASS__,
				'details'     => $details,
				'updated'     => true,
			));
		});

		Role::deleted(function ($model) {
			$affectedRows = Permission::where('role_id', '=', $model->id)->delete();
			if(!$affectedRows){
				Log::info('Role: deleted', array('context' => "Can't delete permission by role id: " . $model->id ));
			}
		});
	}
}