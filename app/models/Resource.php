<?php

class Resource extends \Eloquent
{
	protected $fillable = [];

	protected $table = 'resources';

	const ACTIVE = true;
	const DEACTIVATE = false;

	public static function getResource()
	{
		$rs = Resource::where('status', self::ACTIVE)->get();

		return $rs;
	}

	public static function getResoureToArray(){
		$rs=Resource::all();
		$data=array(''=>'= Select one =');
		foreach($rs as $row){
			$data[$row->id]=$row->description;
		}
		return $data;
	}

	public static function boot()
	{
		parent::boot();

		Resource::saving(function ($model) {
			$details = 'CHANGED DETAILS: <br/>';
			foreach ($model->getDirty() as $attribute => $value) {
				$original = $model->getOriginal($attribute);
				$details .= "$attribute: '$original' => '$value'<br/>";
			}
			Activity::log(array(
				'contentID' => $model->id,
				'contentType' => __CLASS__,
				'description' => 'Thêm/Cập nhật  một ' . __CLASS__,
				'details' => $details,
				'updated' => true,
			));
		});
	}
}